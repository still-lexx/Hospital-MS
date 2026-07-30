<?php

namespace App\Http\Controllers;

use App\Models\LabResult;
use App\Models\LabTestRequest;
use Illuminate\Http\Request;

class LabResultController extends Controller
{
    public function index()
    {
        $results = LabResult::with(['testRequest.patient', 'testRequest.labTest', 'performedBy'])
            ->latest()
            ->paginate(20);
        return view('laboratory.results.index', compact('results'));
    }

    public function create()
    {
        $pendingRequests = LabTestRequest::whereDoesntHave('result')
            ->where('status', '!=', 'cancelled')
            ->with(['patient', 'labTest'])
            ->get();
            
        return view('laboratory.results.create', compact('pendingRequests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'lab_test_request_id' => 'required|exists:lab_test_requests,id',
            'result_value' => 'required|string',
            'result_date' => 'required|date',
            'status' => 'required|in:normal,abnormal,critical',
            'remarks' => 'nullable|string',
        ]);

        $validated['performed_by'] = auth()->id();

        LabResult::create($validated);

        // Update test request status to completed
        LabTestRequest::find($validated['lab_test_request_id'])
            ->update(['status' => 'completed']);

        return redirect()->route('lab-results.index')
            ->with('success', 'Lab result recorded successfully.');
    }

    public function show(LabResult $labResult)
    {
        $labResult->load(['testRequest.patient', 'testRequest.labTest', 'performedBy']);
        return view('laboratory.results.show', compact('labResult'));
    }

    public function edit(LabResult $labResult)
    {
        return view('laboratory.results.edit', compact('labResult'));
    }

    public function update(Request $request, LabResult $labResult)
    {
        $validated = $request->validate([
            'result_value' => 'required|string',
            'result_date' => 'required|date',
            'status' => 'required|in:normal,abnormal,critical',
            'remarks' => 'nullable|string',
        ]);

        $labResult->update($validated);

        return redirect()->route('lab-results.show', $labResult)
            ->with('success', 'Lab result updated successfully.');
    }

    public function destroy(LabResult $labResult)
    {
        $testRequest = $labResult->testRequest;
        $labResult->delete();
        
        // Update test request status back to pending
        $testRequest->update(['status' => 'pending']);
        
        return redirect()->route('lab-results.index')
            ->with('success', 'Lab result deleted successfully.');
    }
}
