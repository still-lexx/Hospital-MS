@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Book Appointment <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Schedule a new appointment</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Appointments</a></li>
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
            <h3 class="block-title">Appointment Details</h3>
        </div>
        <div class="block-content">
            <form action="{{ route('appointments.store') }}" method="POST">
                @csrf
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="font-size-sm text-muted">
                            Select the patient and doctor for this appointment.
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="form-group">
                            <label for="patient_id">Patient</label>
                            <select class="form-control" id="patient_id" name="patient_id" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>{{ $patient->name }} ({{ $patient->phone }})</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="doctor_id">Doctor</label>
                            <select class="form-control" id="doctor_id" name="doctor_id" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>{{ $doctor->user->name ?? $doctor->id }} ({{ $doctor->specialization ?? 'General' }})</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="row push">
                    <div class="col-lg-4">
                        <p class="font-size-sm text-muted">
                            Set the date, time, and type of appointment.
                        </p>
                    </div>
                    <div class="col-lg-8 col-xl-5">
                        <div class="form-group">
                            <label for="appointment_date">Date</label>
                            <input type="date" class="form-control" id="appointment_date" name="appointment_date" value="{{ old('appointment_date') }}" required min="{{ date('Y-m-d') }}">
                        </div>
                        <div class="form-group">
                            <label for="appointment_time">Time</label>
                            <input type="time" class="form-control" id="appointment_time" name="appointment_time" value="{{ old('appointment_time') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="appointment_type">Type</label>
                            <select class="form-control" id="appointment_type" name="appointment_type" required>
                                <option value="consultation" {{ old('appointment_type') == 'consultation' ? 'selected' : '' }}>Consultation</option>
                                <option value="follow-up" {{ old('appointment_type') == 'follow-up' ? 'selected' : '' }}>Follow-up</option>
                                <option value="checkup" {{ old('appointment_type') == 'checkup' ? 'selected' : '' }}>Checkup</option>
                                <option value="emergency" {{ old('appointment_type') == 'emergency' ? 'selected' : '' }}>Emergency</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="reason">Reason</label>
                            <textarea class="form-control" id="reason" name="reason" rows="3" placeholder="Reason for visit...">{{ old('reason') }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="row push">
                    <div class="col-lg-8 col-xl-5 offset-lg-4">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-check mr-1"></i> Schedule Appointment
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
