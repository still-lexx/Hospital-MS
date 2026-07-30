<?php

namespace App\Http\Controllers;

use App\Models\Ward;
use App\Models\Bed;
use Illuminate\Http\Request;

class WardController extends Controller
{
    public function index()
    {
        $wards = Ward::withCount(['beds', 'beds as available_beds_count' => function ($query) {
            $query->where('status', 'available');
        }])->get();
        return view('ipd.wards.index', compact('wards'));
    }

    public function create()
    {
        return view('ipd.wards.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:General,Private,ICU,Emergency',
            'capacity' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Ward::create($validated);

        return redirect()->route('wards.index')->with('success', 'Ward created successfully.');
    }

    public function show(Ward $ward)
    {
        $ward->load('beds');
        return view('ipd.wards.show', compact('ward'));
    }

    // Bed Management Methods
    public function addBed(Request $request, Ward $ward)
    {
        $validated = $request->validate([
            'bed_number' => 'required|string|max:50',
            'daily_charge' => 'required|numeric|min:0',
        ]);

        $ward->beds()->create($validated);

        return back()->with('success', 'Bed added successfully.');
    }
}
