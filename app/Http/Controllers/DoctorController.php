<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DoctorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = \App\Models\Doctor::with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            })->orWhere('specialization', 'like', "%{$search}%");
        }

        $doctors = $query->paginate(10);

        if ($request->ajax()) {
            return view('doctors.partials.list', compact('doctors'))->render();
        }

        return view('doctors.index', compact('doctors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Get users who don't have a doctor profile yet
        $users = \App\Models\User::whereDoesntHave('doctor')->get();
        return view('doctors.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:doctors,user_id',
            'specialization' => 'required|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string',
            'consultation_fee' => 'nullable|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        \App\Models\Doctor::create($validated);

        return redirect()->route('doctors.index')->with('success', 'Doctor profile created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(\App\Models\Doctor $doctor)
    {
        $doctor->load(['user', 'appointments' => function($q) {
            $q->latest()->limit(5);
        }]);
        return view('doctors.show', compact('doctor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Doctor $doctor)
    {
        return view('doctors.edit', compact('doctor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\Doctor $doctor)
    {
        $validated = $request->validate([
            'specialization' => 'required|string|max:255',
            'qualification' => 'nullable|string|max:255',
            'experience' => 'nullable|integer|min:0',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'bio' => 'nullable|string',
            'consultation_fee' => 'nullable|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        $doctor->update($validated);

        return redirect()->route('doctors.index')->with('success', 'Doctor profile updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Doctor $doctor)
    {
        $doctor->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor profile removed successfully.');
    }
}
