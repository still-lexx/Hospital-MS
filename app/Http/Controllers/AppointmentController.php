<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Appointment::with(['patient', 'doctor']);

        // Filter by status (upcoming vs history)
        if ($request->has('view') && $request->view == 'history') {
            $query->whereIn('status', ['completed', 'cancelled']);
        } else {
            $query->whereIn('status', ['scheduled', 'confirmed', 'pending']);
        }

        $appointments = $query->orderBy('appointment_date')->orderBy('appointment_time')->paginate(10);

        return view('appointments.index', compact('appointments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $patients = \App\Models\Patient::all();
        $doctors = \App\Models\Doctor::all();
        return view('appointments.create', compact('patients', 'doctors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date|after_or_equal:today',
            'appointment_time' => 'required',
            'appointment_type' => 'required|in:consultation,follow-up,emergency,checkup',
            'reason' => 'nullable|string',
        ]);

        \App\Models\Appointment::create($validated + ['status' => 'scheduled']);

        return redirect()->route('appointments.index')->with('success', 'Appointment scheduled successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Appointment $appointment)
    {
        return view('appointments.show', compact('appointment'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Appointment $appointment)
    {
        $patients = \App\Models\Patient::all();
        $doctors = \App\Models\Doctor::all();
        return view('appointments.edit', compact('appointment', 'patients', 'doctors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\Appointment $appointment)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:doctors,id',
            'appointment_date' => 'required|date',
            'appointment_time' => 'required',
            'appointment_type' => 'required|in:consultation,follow-up,emergency,checkup',
            'status' => 'required|in:scheduled,confirmed,completed,cancelled,pending',
            'reason' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $appointment->update($validated);

        return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Appointment $appointment)
    {
        $appointment->delete();
        return redirect()->route('appointments.index')->with('success', 'Appointment cancelled successfully.');
    }
}
