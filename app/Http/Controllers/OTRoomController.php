<?php

namespace App\Http\Controllers;

use App\Models\OTRoom;
use Illuminate\Http\Request;

class OTRoomController extends Controller
{
    public function index()
    {
        $otRooms = OTRoom::withCount('surgeries')->paginate(20);
        return view('operations.ot-rooms.index', compact('otRooms'));
    }

    public function create()
    {
        return view('operations.ot-rooms.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:ot_rooms',
            'room_name' => 'required|string',
            'status' => 'required|in:available,occupied,maintenance',
            'equipment' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
        ]);

        OTRoom::create($validated);

        return redirect()->route('ot-rooms.index')
            ->with('success', 'OT Room created successfully.');
    }

    public function show(OTRoom $otRoom)
    {
        $otRoom->load('surgeries.patient');
        return view('operations.ot-rooms.show', compact('otRoom'));
    }

    public function edit(OTRoom $otRoom)
    {
        return view('operations.ot-rooms.edit', compact('otRoom'));
    }

    public function update(Request $request, OTRoom $otRoom)
    {
        $validated = $request->validate([
            'room_number' => 'required|string|unique:ot_rooms,room_number,' . $otRoom->id,
            'room_name' => 'required|string',
            'status' => 'required|in:available,occupied,maintenance',
            'equipment' => 'nullable|string',
            'capacity' => 'required|integer|min:1',
        ]);

        $otRoom->update($validated);

        return redirect()->route('ot-rooms.index')
            ->with('success', 'OT Room updated successfully.');
    }

    public function destroy(OTRoom $otRoom)
    {
        $otRoom->delete();
        return redirect()->route('ot-rooms.index')
            ->with('success', 'OT Room deleted successfully.');
    }
}
