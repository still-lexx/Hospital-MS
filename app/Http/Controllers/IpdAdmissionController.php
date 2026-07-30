<?php

namespace App\Http\Controllers;

use App\Models\IpdAdmission;
use App\Models\Patient;
use App\Models\User;
use App\Models\Ward;
use App\Models\Bed;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IpdAdmissionController extends Controller
{
    public function index()
    {
        $admissions = IpdAdmission::with(['patient', 'doctor', 'bed.ward'])
            ->where('status', 'admitted')
            ->latest('admission_date')
            ->paginate(20);
        return view('ipd.admissions.index', compact('admissions'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = User::whereHas('doctor')->get();
        // Get wards with available beds
        $wards = Ward::with(['beds' => function($q) {
            $q->where('status', 'available');
        }])->get();
        
        return view('ipd.admissions.create', compact('patients', 'doctors', 'wards'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'bed_id' => 'required|exists:beds,id',
            'admission_date' => 'required|date',
            'reason' => 'required|string',
            'deposit_amount' => 'nullable|numeric',
        ]);

        DB::transaction(function () use ($validated) {
            // Create Admission
            IpdAdmission::create($validated);

            // Update Bed Status
            Bed::where('id', $validated['bed_id'])->update(['status' => 'occupied']);
        });

        return redirect()->route('ipd-admissions.index')
            ->with('success', 'Patient admitted successfully.');
    }

    public function show(IpdAdmission $ipdAdmission)
    {
        $ipdAdmission->load(['patient', 'doctor', 'bed.ward']);
        return view('ipd.admissions.show', compact('ipdAdmission'));
    }

    public function discharge(Request $request, IpdAdmission $ipdAdmission)
    {
        $validated = $request->validate([
            'discharge_date' => 'required|date|after_or_equal:admission_date',
            'discharge_summary' => 'required|string',
        ]);

        DB::transaction(function () use ($ipdAdmission, $validated) {
            // Update Admission
            $ipdAdmission->update([
                'status' => 'discharged',
                'discharge_date' => $validated['discharge_date'],
                'discharge_summary' => $validated['discharge_summary'],
            ]);

            // Free up the bed
            $ipdAdmission->bed->update(['status' => 'available']);
        });

        return redirect()->route('ipd-admissions.index')
            ->with('success', 'Patient discharged successfully.');
    }
}
