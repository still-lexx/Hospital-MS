<?php

namespace App\Http\Controllers;

use App\Models\LabTest;
use Illuminate\Http\Request;

class LabTestController extends Controller
{
    public function index()
    {
        $tests = LabTest::latest()->paginate(20);
        return view('laboratory.tests.index', compact('tests'));
    }

    public function create()
    {
        return view('laboratory.tests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
            'normal_range' => 'nullable|string',
            'unit' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        LabTest::create($validated);

        return redirect()->route('lab-tests.index')
            ->with('success', 'Lab test created successfully.');
    }

    public function show(LabTest $labTest)
    {
        return view('laboratory.tests.show', compact('labTest'));
    }

    public function edit(LabTest $labTest)
    {
        return view('laboratory.tests.edit', compact('labTest'));
    }

    public function update(Request $request, LabTest $labTest)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'nullable|string',
            'normal_range' => 'nullable|string',
            'unit' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $labTest->update($validated);

        return redirect()->route('lab-tests.index')
            ->with('success', 'Lab test updated successfully.');
    }

    public function destroy(LabTest $labTest)
    {
        $labTest->delete();
        return redirect()->route('lab-tests.index')
            ->with('success', 'Lab test deleted successfully.');
    }
}
