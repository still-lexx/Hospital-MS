<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\DoctorSchedule;
use Illuminate\Http\Request;

class DoctorScheduleController extends Controller
{
    /**
     * Display a listing of doctor schedules.
     */
    public function index(Request $request)
    {
        $query = DoctorSchedule::with('doctor.user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('doctor.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            });
        }

        $schedules = $query->orderBy('doctor_id')->orderBy('id')->paginate(15);

        return view('doctors.schedules', compact('schedules'));
    }

    /**
     * Show the form for creating a new schedule.
     */
    public function create()
    {
        $doctors = Doctor::with('user')->get();
        return view('doctors.schedules_create', compact('doctors'));
    }

    /**
     * Store a newly created schedule in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'doctor_id' => 'required|exists:doctors,id',
            'day_of_week' => 'required|in:monday,tuesday,wednesday,thursday,friday,saturday,sunday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'slot_duration' => 'required|integer|min:10|max:120',
            'is_available' => 'boolean',
        ]);

        // Check for existing schedule for this doctor on this day
        $exists = DoctorSchedule::where('doctor_id', $validated['doctor_id'])
            ->where('day_of_week', $validated['day_of_week'])
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['day_of_week' => 'This doctor already has a schedule for the selected day.']);
        }

        DoctorSchedule::create($validated);

        return redirect()->route('doctors.schedules')
            ->with('success', 'Schedule added successfully.');
    }

    /**
     * Remove the specified schedule from storage.
     */
    public function destroy(DoctorSchedule $schedule)
    {
        $schedule->delete();
        return redirect()->route('doctors.schedules')
            ->with('success', 'Schedule removed successfully.');
    }
}
