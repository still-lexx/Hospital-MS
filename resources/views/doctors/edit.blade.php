@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Edit Doctor <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Update doctor profile</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('doctors.index') }}">Doctors</a></li>
                    <li class="breadcrumb-item" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Doctor Profile: {{ $doctor->user->name ?? 'N/A' }}</h3>
        </div>
        <div class="block-content">
            <form action="{{ route('doctors.update', $doctor) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="font-size-sm text-muted">
                            Update professional details.
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="form-group">
                            <label for="specialization">Specialization</label>
                            <input type="text" class="form-control" id="specialization" name="specialization" value="{{ old('specialization') ?? $doctor->specialization }}" required>
                        </div>
                        <div class="form-group">
                            <label for="qualification">Qualification</label>
                            <input type="text" class="form-control" id="qualification" name="qualification" value="{{ old('qualification') ?? $doctor->qualification }}">
                        </div>
                        <div class="form-group">
                            <label for="experience">Experience (Years)</label>
                            <input type="number" class="form-control" id="experience" name="experience" value="{{ old('experience') ?? $doctor->experience }}" min="0">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="text" class="form-control" id="phone" name="phone" value="{{ old('phone') ?? $doctor->phone }}">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="2">{{ old('address') ?? $doctor->address }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="consultation_fee">Consultation Fee</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">$</span>
                                </div>
                                <input type="number" class="form-control" id="consultation_fee" name="consultation_fee" value="{{ old('consultation_fee') ?? $doctor->consultation_fee }}" min="0" step="0.01">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="d-block">Availability</label>
                            <div class="custom-control custom-switch custom-control-success">
                                <input type="checkbox" class="custom-control-input" id="is_available" name="is_available" value="1" {{ (old('is_available') ?? $doctor->is_available) ? 'checked' : '' }}>
                                <label class="custom-control-label" for="is_available">Available for appointments</label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="bio">Bio</label>
                            <textarea class="form-control" id="bio" name="bio" rows="4">{{ old('bio') ?? $doctor->bio }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row push">
                    <div class="col-lg-8 col-xl-5 offset-lg-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check mr-1"></i> Update Profile
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
