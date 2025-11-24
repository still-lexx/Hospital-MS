<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Appointment;

class SearchController extends Controller
{
    /**
     * Handle global search across the application
     */
    public function search(Request $request)
    {
        $query = $request->input('q');
        
        if (empty($query)) {
            if ($request->ajax() || $request->input('ajax')) {
                return response()->json([
                    'patients' => [],
                    'doctors' => [],
                    'appointments' => []
                ]);
            }
            return redirect()->back()->with('info', 'Please enter a search term');
        }

        // Search patients
        $patients = Patient::where('name', 'LIKE', "%{$query}%")
            ->orWhere('phone', 'LIKE', "%{$query}%")
            ->orWhere('address', 'LIKE', "%{$query}%")
            ->limit(10)
            ->get();

        // Search doctors (if Doctor model exists)
        $doctors = [];
        if (class_exists('App\Models\Doctor')) {
            $doctors = Doctor::with('user')
                ->where('specialization', 'LIKE', "%{$query}%")
                ->orWhereHas('user', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->limit(10)
                ->get();
        }

        // Search appointments (if needed)
        $appointments = [];
        if (class_exists('App\Models\Appointment')) {
            $appointments = Appointment::with(['patient', 'doctor.user'])
                ->whereHas('patient', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->orWhereHas('doctor.user', function($q) use ($query) {
                    $q->where('name', 'LIKE', "%{$query}%");
                })
                ->limit(10)
                ->get();
        }

        // Return JSON for AJAX requests
        if ($request->ajax() || $request->input('ajax')) {
            return response()->json([
                'patients' => $patients->map(function($patient) {
                    return [
                        'id' => $patient->id,
                        'name' => $patient->name,
                        'phone' => $patient->phone,
                        'gender' => $patient->gender,
                    ];
                }),
                'doctors' => collect($doctors)->map(function($doctor) {
                    return [
                        'id' => $doctor->id,
                        'name' => $doctor->user->name ?? 'N/A',
                        'specialization' => $doctor->specialization,
                    ];
                }),
                'appointments' => collect($appointments)->map(function($appointment) {
                    return [
                        'id' => $appointment->id,
                        'patient_name' => $appointment->patient->name ?? 'N/A',
                        'doctor_name' => $appointment->doctor->user->name ?? 'N/A',
                        'date' => $appointment->appointment_date ?? 'N/A',
                    ];
                }),
            ]);
        }

        return view('search.results', compact('query', 'patients', 'doctors', 'appointments'));
    }
}
