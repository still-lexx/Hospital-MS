<?php

namespace App\Http\Controllers;

use App\Models\OpdConsultation;
use App\Models\OpdVisit;
use Illuminate\Http\Request;

class OpdConsultationController extends Controller
{
    public function index()
    {
        // Show visits assigned to current doctor or all if admin
        $visits = OpdVisit::with(['patient', 'vitals'])
            ->where('status', 'waiting')
            ->orWhere('status', 'in-consultation')
            ->latest('visit_date')
            ->paginate(20);
            
        return view('opd.consultations.index', compact('visits'));
    }

    public function create(OpdVisit $visit)
    {
        $visit->load(['patient', 'vitals']);
        // Update status to in-consultation
        if ($visit->status == 'waiting') {
            $visit->update(['status' => 'in-consultation']);
        }
        return view('opd.consultations.create', compact('visit'));
    }

    public function store(Request $request, OpdVisit $visit)
    {
        $validated = $request->validate([
            'diagnosis' => 'required|string',
            'symptoms' => 'nullable|string',
            'examination_notes' => 'nullable|string',
            'advice' => 'nullable|string',
            'next_visit_date' => 'nullable|date',
        ]);

        $visit->consultation()->create($validated);
        $visit->update(['status' => 'completed']);

        return redirect()->route('opd-consultations.index')
            ->with('success', 'Consultation completed successfully.');
    }

    public function show(OpdConsultation $opdConsultation)
    {
        $opdConsultation->load(['visit.patient', 'visit.vitals']);
        return view('opd.consultations.show', compact('opdConsultation'));
    }
}
