<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\StorePatientRequest;
use App\Http\Requests\UpdatePatientRequest;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Patient::with('ward');
        
        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('address', 'like', "%{$search}%");
            });
        }
        
        // Filter by status
        if ($request->has('status')) {
            if ($request->status == 'new') {
                $query->where('created_at', '>=', now()->subDays(30));
            } elseif ($request->status == 'admitted') {
                $query->where('admitted', 1);
            }
        }

        $patients = $query->latest()->paginate(5);
        
        // Calculate statistics
        $stats = [
            'total' => Patient::count(),
            'admitted' => Patient::where('admitted', 1)->count(),
            'new' => Patient::where('created_at', '>=', now()->subDays(30))->count(),
        ];
        
        return view('patients.index', compact('patients', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('patients.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePatientRequest $request)
    {

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('patients/photos', 'public');
        }


        $user = Auth::User();
         // Create patient record
         Patient::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'genotype' => $request->genotype,
            'marital_status' => $request->marital_status,
            'emergency_contact' => $request->emergency_contact,
            'allergies' => $request->allergies,
            'conditions' => $request->conditions,
            'ward_id' => $request->ward_id,
            'admitted' => $request->has('admitted') ? 1 : 0,
            'photo' => $photoPath,
        ]);

        return redirect()->route('patients.index')->with('success', 'Patient registered successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.show', compact('patient'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $patient = Patient::findOrFail($id);
        return view('patients.edit', compact('patient'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePatientRequest $request, string $id)
    {
        $patient = Patient::findOrFail($id);
        
        // Handle photo upload
        $photoPath = $patient->photo; // Keep existing photo by default
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($patient->photo && \Storage::disk('public')->exists($patient->photo)) {
                \Storage::disk('public')->delete($patient->photo);
            }
            $photoPath = $request->file('photo')->store('patients/photos', 'public');
        }
        
        // Update patient record
        $patient->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
            'blood_group' => $request->blood_group,
            'genotype' => $request->genotype,
            'marital_status' => $request->marital_status,
            'emergency_contact' => $request->emergency_contact,
            'allergies' => $request->allergies,
            'conditions' => $request->conditions,
            'ward' => $request->ward,
            'admitted' => $request->admitted,
            'photo' => $photoPath,
        ]);
        
        return redirect()->route('patients.index')->with('success', 'Patient updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Check if user has admin role before allowing deletion
        if (Auth()->User()->hasRole('admin')) {
            Patient::where('id', $id)->delete();
            return redirect()->route('patients.index')->with('success', 'Patient deleted successfully.');
        }
        
        // Unauthorized access
        return redirect()->route('patients.index')->with('error', 'Unauthorized action. Admin access required.');
    }

 
}
