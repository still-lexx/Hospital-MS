@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Edit Patient <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Update patient information</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('patients.show', $patient->id) }}">{{ $patient->name }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <!-- Edit Patient Form Block -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Patient Information</h3>
            <div class="block-options">
                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-secondary">
                    <i class="fa fa-times mr-1"></i> Cancel
                </a>
            </div>
        </div>
        <div class="block-content block-content-full">
            <form method="POST" action="{{ route('patients.update', $patient->id) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="row push">
                    <!-- Personal Information -->
                    <div class="col-lg-6">
                        <h4 class="mb-3">Personal Information</h4>
                        
                        <div class="form-group">
                            <label for="name">Full Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name', $patient->name) }}" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender <span class="text-danger">*</span></label>
                            <select class="form-control @error('gender') is-invalid @enderror" id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="male" {{ old('gender', $patient->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $patient->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="other" {{ old('gender', $patient->gender) == 'other' ? 'selected' : '' }}>Other</option>
                            </select>
                            @error('gender')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="date_of_birth">Date of Birth <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('date_of_birth') is-invalid @enderror" 
                                   id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth) }}" required>
                            @error('date_of_birth')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="blood_group">Blood Group</label>
                            <select class="form-control @error('blood_group') is-invalid @enderror" id="blood_group" name="blood_group">
                                <option value="">Select Blood Group</option>
                                <option value="A+" {{ old('blood_group', $patient->blood_group) == 'A+' ? 'selected' : '' }}>A+</option>
                                <option value="A-" {{ old('blood_group', $patient->blood_group) == 'A-' ? 'selected' : '' }}>A-</option>
                                <option value="B+" {{ old('blood_group', $patient->blood_group) == 'B+' ? 'selected' : '' }}>B+</option>
                                <option value="B-" {{ old('blood_group', $patient->blood_group) == 'B-' ? 'selected' : '' }}>B-</option>
                                <option value="AB+" {{ old('blood_group', $patient->blood_group) == 'AB+' ? 'selected' : '' }}>AB+</option>
                                <option value="AB-" {{ old('blood_group', $patient->blood_group) == 'AB-' ? 'selected' : '' }}>AB-</option>
                                <option value="O+" {{ old('blood_group', $patient->blood_group) == 'O+' ? 'selected' : '' }}>O+</option>
                                <option value="O-" {{ old('blood_group', $patient->blood_group) == 'O-' ? 'selected' : '' }}>O-</option>
                            </select>
                            @error('blood_group')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="genotype">Genotype</label>
                            <select class="form-control @error('genotype') is-invalid @enderror" id="genotype" name="genotype">
                                <option value="">Select Genotype</option>
                                <option value="AA" {{ old('genotype', $patient->genotype) == 'AA' ? 'selected' : '' }}>AA</option>
                                <option value="AS" {{ old('genotype', $patient->genotype) == 'AS' ? 'selected' : '' }}>AS</option>
                                <option value="SS" {{ old('genotype', $patient->genotype) == 'SS' ? 'selected' : '' }}>SS</option>
                                <option value="AC" {{ old('genotype', $patient->genotype) == 'AC' ? 'selected' : '' }}>AC</option>
                            </select>
                            @error('genotype')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="marital_status">Marital Status</label>
                            <select class="form-control @error('marital_status') is-invalid @enderror" id="marital_status" name="marital_status">
                                <option value="">Select Status</option>
                                <option value="single" {{ old('marital_status', $patient->marital_status) == 'single' ? 'selected' : '' }}>Single</option>
                                <option value="married" {{ old('marital_status', $patient->marital_status) == 'married' ? 'selected' : '' }}>Married</option>
                                <option value="divorced" {{ old('marital_status', $patient->marital_status) == 'divorced' ? 'selected' : '' }}>Divorced</option>
                                <option value="widowed" {{ old('marital_status', $patient->marital_status) == 'widowed' ? 'selected' : '' }}>Widowed</option>
                            </select>
                            @error('marital_status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="photo">Patient Photo</label>
                            @if($patient->photo)
                                <div class="mb-2">
                                    <img src="{{ asset('storage/' . $patient->photo) }}" alt="{{ $patient->name }}" class="img-thumbnail" style="max-width: 150px;">
                                </div>
                            @endif
                            <input type="file" class="form-control @error('photo') is-invalid @enderror" 
                                   id="photo" name="photo" accept="image/*">
                            <small class="form-text text-muted">Upload a new photo to replace the existing one</small>
                            @error('photo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Contact & Medical Information -->
                    <div class="col-lg-6">
                        <h4 class="mb-3">Contact Information</h4>
                        
                        <div class="form-group">
                            <label for="phone">Phone Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('phone') is-invalid @enderror" 
                                   id="phone" name="phone" value="{{ old('phone', $patient->phone) }}" required>
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">Address <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('address') is-invalid @enderror" 
                                      id="address" name="address" rows="3" required>{{ old('address', $patient->address) }}</textarea>
                            @error('address')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="emergency_contact">Emergency Contact <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('emergency_contact') is-invalid @enderror" 
                                   id="emergency_contact" name="emergency_contact" value="{{ old('emergency_contact', $patient->emergency_contact) }}" required>
                            @error('emergency_contact')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <h4 class="mb-3 mt-4">Medical Information</h4>

                        <div class="form-group">
                            <label for="allergies">Allergies</label>
                            <textarea class="form-control @error('allergies') is-invalid @enderror" 
                                      id="allergies" name="allergies" rows="2" placeholder="List any known allergies">{{ old('allergies', $patient->allergies) }}</textarea>
                            @error('allergies')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="conditions">Medical Conditions</label>
                            <textarea class="form-control @error('conditions') is-invalid @enderror" 
                                      id="conditions" name="conditions" rows="2" placeholder="List any existing medical conditions">{{ old('conditions', $patient->conditions) }}</textarea>
                            @error('conditions')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="ward_id">Ward</label>
                            <select class="form-control @error('ward_id') is-invalid @enderror" id="ward_id" name="ward_id">
                                <option value="">Select Ward</option>
                                @foreach(\App\Models\Ward::all() as $ward)
                                    <option value="{{ $ward->id }}" {{ old('ward_id', $patient->ward_id) == $ward->id ? 'selected' : '' }}>
                                        {{ $ward->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('ward_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="admitted" name="admitted" value="1" 
                                       {{ old('admitted', $patient->admitted) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="admitted">Patient is currently admitted</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Form Actions -->
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check mr-1"></i> Update Patient
                            </button>
                            <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-secondary">
                                <i class="fa fa-times mr-1"></i> Cancel
                            </a>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- END Edit Patient Form Block -->
</div>
@endsection
