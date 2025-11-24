@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Add Doctor <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Create a new doctor profile</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('doctors.index') }}">Doctors</a></li>
                    <li class="breadcrumb-item" aria-current="page">New</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Doctor Profile</h3>
        </div>
        <div class="block-content">
            <form action="{{ route('doctors.store') }}" method="POST">
                @csrf
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="font-size-sm text-muted">
                            Select a user account to promote to a doctor.
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="form-group">
                            <label for="user_id">User Account</label>
                            <select class="form-control" id="user_id" name="user_id" required>
                                <option value="">Select User</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>{{ $user->name }} ({{ $user->email }})</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Only users without an existing doctor profile are listed.</small>
                        </div>
                    </div>
                </div>
                
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="font-size-sm text-muted">
                            Enter professional details.
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <input type="text" class="form-control" id="specialization" name="specialization" value="{{ old('specialization') }}" required placeholder="e.g. Cardiologist, General Practitioner">
                        </div>
                        <div class="form-group">
                            <label for="qualification">Qualification</label>
                            <input type="text" class="form-control" id="qualification" name="qualification" value="{{ old('qualification') }}" placeholder="e.g. MBBS, MD">
                        </div>
                        <div class="form-group">
                            <label for="experience">Experience (Years)</label>
                            <input type="number" class="form-control" id="experience" name="experience" value="{{ old('experience') }}" min="0">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2">{{ old('address') }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="consultation_fee">Consultation Fee</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" class="form-control" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee') }}" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Availability</label>
                            <div class="custom-control custom-switch custom-control-success">
                                <input type="checkbox" class="custom-control-input" id="is_available" name="is_available" value="1" {{ old('is_available', 1) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_available">Available for appointments</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4" placeholder="Brief biography...">{{ old('bio') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row push">
                    <div class="col-lg-8 col-xl-5 offset-lg-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check mr-1"></i> Create Doctor Profile
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
