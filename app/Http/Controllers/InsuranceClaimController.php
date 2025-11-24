<?php

namespace App\Http\Controllers;

use App\Models\InsuranceClaim;
use App\Models\Patient;
use App\Models\Invoice;
use Illuminate\Http\Request;

class InsuranceClaimController extends Controller
{
    /**
     * Display a listing of insurance claims.
     */
    public function index(Request $request)
    {
        $query = InsuranceClaim::with(['patient', 'invoice']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $claims = $query->latest()->paginate(15);

        return view('billing.insurance.index', compact('claims'));
    }

    /**
     * Show the form for creating a new claim.
     */
    public function create()
    {
        $patients = Patient::orderBy('name')->get();
        $invoices = Invoice::with('patient')->where('status', '!=', 'cancelled')->latest()->get();
        
        return view('billing.insurance.create', compact('patients', 'invoices'));
    }

    /**
     * Store a newly created claim.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_id' => 'required|exists:invoices,id',
            'provider_name' => 'required|string',
            'policy_number' => 'required|string',
            'claim_number' => 'nullable|string',
            'claim_amount' => 'required|numeric|min:0',
        ]);

        $claim = InsuranceClaim::create(array_merge($validated, [
            'status' => 'pending',
        ]));

        return redirect()->route('insurance-claims.index')
            ->with('success', 'Insurance claim submitted successfully.');
    }

    /**
     * Display the specified claim.
     */
    public function show(InsuranceClaim $insuranceClaim)
    {
        $insuranceClaim->load(['patient', 'invoice']);
        
        return view('billing.insurance.show', compact('insuranceClaim'));
    }

    /**
     * Show the form for editing the claim.
     */
    public function edit(InsuranceClaim $insuranceClaim)
    {
        $patients = Patient::orderBy('name')->get();
        $invoices = Invoice::with('patient')->where('status', '!=', 'cancelled')->latest()->get();
        
        return view('billing.insurance.edit', compact('insuranceClaim', 'patients', 'invoices'));
    }

    /**
     * Update the specified claim.
     */
    public function update(Request $request, InsuranceClaim $insuranceClaim)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'invoice_id' => 'required|exists:invoices,id',
            'provider_name' => 'required|string',
            'policy_number' => 'required|string',
            'claim_number' => 'nullable|string',
            'status' => 'required|in:pending,approved,rejected',
            'claim_amount' => 'required|numeric|min:0',
            'approved_amount' => 'nullable|numeric|min:0',
        ]);

        $insuranceClaim->update($validated);

        return redirect()->route('insurance-claims.show', $insuranceClaim)
            ->with('success', 'Insurance claim updated successfully.');
    }

    /**
     * Remove the specified claim.
     */
    public function destroy(InsuranceClaim $insuranceClaim)
    {
        $insuranceClaim->delete();
        
        return redirect()->route('insurance-claims.index')
            ->with('success', 'Insurance claim deleted successfully.');
    }
}
