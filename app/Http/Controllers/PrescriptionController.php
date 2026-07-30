<?php

namespace App\Http\Controllers;

use App\Models\Prescription;
use App\Models\Patient;
use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PrescriptionController extends Controller
{
    public function index()
    {
        $prescriptions = Prescription::with(['patient', 'doctor', 'items'])
            ->latest()
            ->paginate(20);
        return view('pharmacy.prescriptions.index', compact('prescriptions'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = User::whereHas('doctor')->get();
        return view('pharmacy.prescriptions.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:users,id',
            'prescription_date' => 'required|date',
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.medicine_name' => 'required|string',
            'items.*.dosage' => 'required|string',
            'items.*.frequency' => 'required|string',
            'items.*.duration' => 'required|string',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.instructions' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $prescription = Prescription::create([
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $validated['doctor_id'],
                'prescription_date' => $validated['prescription_date'],
                'notes' => $validated['notes'],
                'status' => 'active',
            ]);

            foreach ($validated['items'] as $item) {
                $prescription->items()->create($item);
            }

            DB::commit();
            return redirect()->route('prescriptions.show', $prescription)
                ->with('success', 'Prescription created successfully.');
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Error creating prescription: ' . $e->getMessage());
        }
    }

    public function show(Prescription $prescription)
    {
        $prescription->load(['patient', 'doctor', 'items']);
        return view('pharmacy.prescriptions.show', compact('prescription'));
    }

    public function edit(Prescription $prescription)
    {
        $patients = Patient::all();
        $doctors = User::whereHas('doctor')->get();
        return view('pharmacy.prescriptions.edit', compact('prescription', 'patients', 'doctors'));
    }

    public function update(Request $request, Prescription $prescription)
    {
        $validated = $request->validate([
            'status' => 'required|in:active,completed,cancelled',
            'notes' => 'nullable|string',
        ]);

        $prescription->update($validated);

        return redirect()->route('prescriptions.show', $prescription)
            ->with('success', 'Prescription updated successfully.');
    }

    public function destroy(Prescription $prescription)
    {
        $prescription->delete();
        return redirect()->route('prescriptions.index')
            ->with('success', 'Prescription deleted successfully.');
    }
}
