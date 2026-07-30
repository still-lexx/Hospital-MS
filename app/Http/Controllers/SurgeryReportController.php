<?php

namespace App\Http\Controllers;

use App\Models\SurgeryReport;
use App\Models\Surgery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SurgeryReportController extends Controller
{
    public function index()
    {
        $reports = SurgeryReport::with(['surgery.patient', 'reporter'])
            ->latest()
            ->paginate(20);
        return view('operations.reports.index', compact('reports'));
    }

    public function create()
    {
        $surgeries = Surgery::whereDoesntHave('report')
            ->where('status', 'completed')
            ->with(['patient', 'doctor'])
            ->get();
        return view('operations.reports.create', compact('surgeries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'surgery_id' => 'required|exists:surgeries,id|unique:surgery_reports',
            'pre_operative_diagnosis' => 'required|string',
            'post_operative_diagnosis' => 'nullable|string',
            'procedure_details' => 'required|string',
            'complications' => 'nullable|string',
            'blood_loss' => 'nullable|string',
            'report_date' => 'required|date',
        ]);

        $validated['reported_by'] = Auth::id();

        $report = SurgeryReport::create($validated);

        return redirect()->route('surgery-reports.show', $report)
            ->with('success', 'Surgery report created successfully.');
    }

    public function show(SurgeryReport $surgeryReport)
    {
        $surgeryReport->load(['surgery.patient', 'surgery.doctor', 'surgery.otRoom', 'reporter']);
        return view('operations.reports.show', compact('surgeryReport'));
    }

    public function edit(SurgeryReport $surgeryReport)
    {
        return view('operations.reports.edit', compact('surgeryReport'));
    }

    public function update(Request $request, SurgeryReport $surgeryReport)
    {
        $validated = $request->validate([
            'pre_operative_diagnosis' => 'required|string',
            'post_operative_diagnosis' => 'nullable|string',
            'procedure_details' => 'required|string',
            'complications' => 'nullable|string',
            'blood_loss' => 'nullable|string',
            'report_date' => 'required|date',
        ]);

        $surgeryReport->update($validated);

        return redirect()->route('surgery-reports.show', $surgeryReport)
            ->with('success', 'Surgery report updated successfully.');
    }

    public function destroy(SurgeryReport $surgeryReport)
    {
        $surgeryReport->delete();
        return redirect()->route('surgery-reports.index')
            ->with('success', 'Surgery report deleted successfully.');
    }
}
