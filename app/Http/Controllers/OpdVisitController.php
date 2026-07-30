<?php

namespace App\Http\Controllers;

use App\Models\OpdVisit;
use App\Models\Patient;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OpdVisitController extends Controller
{
    public function index()
    {
        $visits = OpdVisit::with(['patient', 'doctor', 'vitals'])
            ->latest('visit_date')
            ->paginate(20);
        return view('opd.visits.index', compact('visits'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = User::whereHas('doctor')->get();
        return view('opd.visits.create', compact('patients', 'doctors'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'reason' => 'nullable|string',
            // Vitals validation
            'weight' => 'nullable|numeric',
            'height' => 'nullable|numeric',
            'bp_systolic' => 'nullable|integer',
            'bp_diastolic' => 'nullable|integer',
            'temperature' => 'nullable|numeric',
            'pulse' => 'nullable|integer',
            'spo2' => 'nullable|integer',
        ]);

        DB::beginTransaction();
        try {
            // Generate Token Number (Simple format: YMD-ID)
            $visit = OpdVisit::create([
                'patient_id' => $validated['patient_id'],
                'doctor_id' => $validated['doctor_id'],
                'visit_date' => now(),
                'reason' => $validated['reason'],
                'status' => 'waiting',
                'token_number' => date('ymd') . '-' . rand(100, 999),
            ]);

            // Create Vitals if any provided
            if ($request->hasAny(['weight', 'height', 'bp_systolic', 'bp_diastolic', 'temperature', 'pulse', 'spo2'])) {
                $visit->vitals()->create($request->only([
                    'weight', 'height', 'bp_systolic', 'bp_diastolic', 'temperature', 'pulse', 'spo2'
                ]));
            }

            DB::commit();
            return redirect()->route('opd-visits.index')
                ->with('success', 'Patient registered for OPD successfully. Token: ' . $visit->token_number);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Error registering patient.');
        }
    }

    public function show(OpdVisit $opdVisit)
    {
        $opdVisit->load(['patient', 'doctor', 'vitals', 'consultation']);
        return view('opd.visits.show', compact('opdVisit'));
    }
}
