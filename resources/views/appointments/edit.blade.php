@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Edit Appointment <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Update appointment details</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Appointments</a></li>
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
            <h3 class="block-title">Appointment Details</h3>
        </div>
        <div class="block-content">
            <form action="{{ route('appointments.update', $appointment) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="font-size-sm text-muted">
                            Update patient and doctor information if needed.
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="form-group">
                            <label for="patient_id">Patient</label>
                            <select class="form-control" id="patient_id" name="patient_id" required>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ (old('patient_id') ?? $appointment->patient_id) == $patient->id ? 'selected' : '' }}>{{ $patient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="doctor_id">Doctor</label>
                            <select class="form-control" id="doctor_id" name="doctor_id" required>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ (old('doctor_id') ?? $appointment->doctor_id) == $doctor->id ? 'selected' : '' }}>{{ $doctor->user->name ?? $doctor->id }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="font-size-sm text-muted">
                            Update schedule and status.
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="form-group">
                            <label for="appointment_date">Date</label>
                            <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') ?? $appointment->appointment_date->format('Y-m-d') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="appointment_time">Time</label>
                            <input type="time" class="form-control" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') ?? \Carbon\Carbon::parse($appointment->appointment_time)->format('H:i') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="appointment_type">Type</label>
                            <select class="form-control" id="appointment_type" name="appointment_type" required>
                                <option value="consultation" {{ (old('appointment_type') ?? $appointment->appointment_type) == 'consultation' ? 'selected' : '' }}>Consultation</option>
                                <option value="follow-up" {{ (old('appointment_type') ?? $appointment->appointment_type) == 'follow-up' ? 'selected' : '' }}>Follow-up</option>
                                <option value="checkup" {{ (old('appointment_type') ?? $appointment->appointment_type) == 'checkup' ? 'selected' : '' }}>Checkup</option>
                                <option value="emergency" {{ (old('appointment_type') ?? $appointment->appointment_type) == 'emergency' ? 'selected' : '' }}>Emergency</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="scheduled" {{ (old('status') ?? $appointment->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="confirmed" {{ (old('status') ?? $appointment->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                <option value="completed" {{ (old('status') ?? $appointment->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ (old('status') ?? $appointment->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                <option value="pending" {{ (old('status') ?? $appointment->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3">{{ old('reason') ?? $appointment->reason }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') ?? $appointment->notes }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row push">
                    <div class="col-lg-8 col-xl-5 offset-lg-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check mr-1"></i> Update Appointment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
