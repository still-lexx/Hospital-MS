<?php

namespace App\Http\Controllers;

use App\Models\LabTestRequest;
use App\Models\LabTest;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;

class LabTestRequestController extends Controller
{
    public function index()
    {
        $requests = LabTestRequest::with(['patient', 'doctor', 'labTest', 'result'])
            ->latest()
            ->paginate(20);
        return view('laboratory.requests.index', compact('requests'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = User::whereHas('doctor')->get();
        $labTests = LabTest::where('status', 'active')->get();
        
        return view('laboratory.requests.create', compact('patients', 'doctors', 'labTests'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:users,id',
            'lab_test_id' => 'required|exists:lab_tests,id',
            'request_date' => 'required|date',
            'priority' => 'required|in:normal,urgent,stat',
            'notes' => 'nullable|string',
        ]);

        LabTestRequest::create($validated);

        return redirect()->route('lab-test-requests.index')
            ->with('success', 'Test request created successfully.');
    }

    public function show(LabTestRequest $labTestRequest)
    {
        $labTestRequest->load(['patient', 'doctor', 'labTest', 'result']);
        return view('laboratory.requests.show', compact('labTestRequest'));
    }

    public function edit(LabTestRequest $labTestRequest)
    {
        $patients = Patient::all();
        $doctors = User::whereHas('doctor')->get();
        $labTests = LabTest::where('status', 'active')->get();
        
        return view('laboratory.requests.edit', compact('labTestRequest', 'patients', 'doctors', 'labTests'));
    }

    public function update(Request $request, LabTestRequest $labTestRequest)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'nullable|exists:users,id',
            'lab_test_id' => 'required|exists:lab_tests,id',
            'request_date' => 'required|date',
            'status' => 'required|in:pending,in-progress,completed,cancelled',
            'priority' => 'required|in:normal,urgent,stat',
            'notes' => 'nullable|string',
        ]);

        $labTestRequest->update($validated);

        return redirect()->route('lab-test-requests.show', $labTestRequest)
            ->with('success', 'Test request updated successfully.');
    }

    public function destroy(LabTestRequest $labTestRequest)
    {
        $labTestRequest->delete();
        return redirect()->route('lab-test-requests.index')
            ->with('success', 'Test request deleted successfully.');
    }
}
