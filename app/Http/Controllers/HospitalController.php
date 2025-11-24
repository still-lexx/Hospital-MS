<?php

namespace App\Http\Controllers;

use App\Models\Hospital;
use Illuminate\Http\Request;

class HospitalController extends Controller
{
    public function edit()
    {
        $hospital = Hospital::first();
        return view('hospital.edit', compact('hospital'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'footer_text' => 'nullable|string|max:255',
        ]);

        $hospital = Hospital::first();
        if (!$hospital) {
            $hospital = new Hospital();
        }

        $data = $request->all();

        if ($request->hasFile('logo')) {
            $imageName = time().'.'.$request->logo->extension();
            $request->logo->move(public_path('images'), $imageName);
            $data['logo'] = $imageName;
        }

        $hospital->fill($data);
        $hospital->save();

        return redirect()->back()->with('success', 'Hospital settings updated successfully.');
    }
}
