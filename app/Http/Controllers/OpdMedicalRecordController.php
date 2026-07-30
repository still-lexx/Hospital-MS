<?php

namespace App\Http\Controllers;

use App\Models\OpdVisit;
use Illuminate\Http\Request;

class OpdMedicalRecordController extends Controller
{
    public function index(Request $request)
    {
        $query = OpdVisit::with(['patient', 'doctor', 'consultation'])
            ->where('status', 'completed')
            ->latest('visit_date');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('patient', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $records = $query->paginate(20);

        return view('opd.records.index', compact('records'));
    }

    public function show(OpdVisit $visit)
    {
        // Ensure we can only view completed visits or visits with consultations
        if ($visit->status !== 'completed' && !$visit->consultation) {
            return redirect()->route('opd-records.index')
                ->with('error', 'Medical record not available for incomplete visits.');
        }

        $visit->load(['patient', 'doctor', 'vitals', 'consultation']);
        
        return view('opd.records.show', compact('visit'));
    }
}
