<?php

namespace App\Http\Controllers;

use App\Models\Surgery;
use App\Models\Patient;
use App\Models\User;
use App\Models\OTRoom;
use Illuminate\Http\Request;

class SurgeryController extends Controller
{
    public function index()
    {
        $surgeries = Surgery::with(['patient', 'doctor', 'otRoom'])
            ->latest('surgery_date')
            ->paginate(20);
        return view('operations.surgeries.index', compact('surgeries'));
    }

    public function create()
    {
        $patients = Patient::all();
        $doctors = User::whereHas('doctor')->get();
        $otRooms = OTRoom::where('status', 'available')->get();
        return view('operations.surgeries.create', compact('patients', 'doctors', 'otRooms'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'patient_id' => 'required|exists:patients,id',
            'doctor_id' => 'required|exists:users,id',
            'ot_room_id' => 'nullable|exists:ot_rooms,id',
            'surgery_name' => 'required|string',
            'surgery_date' => 'required|date',
            'start_time' => 'nullable',
            'type' => 'required|in:emergency,elective',
            'notes' => 'nullable|string',
        ]);

        $surgery = Surgery::create($validated);

        return redirect()->route('surgeries.show', $surgery)
            ->with('success', 'Surgery scheduled successfully.');
    }

    public function show(Surgery $surgery)
    {
        $surgery->load(['patient', 'doctor', 'otRoom', 'team.user', 'report']);
        return view('operations.surgeries.show', compact('surgery'));
    }

    public function edit(Surgery $surgery)
    {
        $patients = Patient::all();
        $doctors = User::whereHas('doctor')->get();
        $otRooms = OTRoom::all();
        return view('operations.surgeries.edit', compact('surgery', 'patients', 'doctors', 'otRooms'));
    }

    public function update(Request $request, Surgery $surgery)
    {
        $validated = $request->validate([
            'status' => 'required|in:scheduled,in-progress,completed,cancelled',
            'start_time' => 'nullable',
            'end_time' => 'nullable',
            'notes' => 'nullable|string',
        ]);

        $surgery->update($validated);

        return redirect()->route('surgeries.show', $surgery)
            ->with('success', 'Surgery updated successfully.');
    }

    public function destroy(Surgery $surgery)
    {
        $surgery->delete();
        return redirect()->route('surgeries.index')
            ->with('success', 'Surgery deleted successfully.');
    }
}
