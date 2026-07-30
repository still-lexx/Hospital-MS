@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">New OPD Registration</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('opd-visits.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Patient <span class="text-danger">*</span></label>
                            <select class="form-control" name="patient_id" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Doctor <span class="text-danger">*</span></label>
                            <select class="form-control" name="doctor_id" required>
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Reason for Visit</label>
                    <textarea class="form-control" name="reason" rows="2"></textarea>
                </div>

                <h4 class="mt-4">Vital Signs (Optional)</h4>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Weight (kg)</label>
                            <input type="number" step="0.1" class="form-control" name="weight">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Height (cm)</label>
                            <input type="number" step="0.1" class="form-control" name="height">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Temperature (°C)</label>
                            <input type="number" step="0.1" class="form-control" name="temperature">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Pulse (bpm)</label>
                            <input type="number" class="form-control" name="pulse">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>BP Systolic</label>
                            <input type="number" class="form-control" name="bp_systolic">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>BP Diastolic</label>
                            <input type="number" class="form-control" name="bp_diastolic">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>SPO2 (%)</label>
                            <input type="number" class="form-control" name="spo2">
                        </div>
                    </div>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-primary">Register Patient</button>
                    <a href="{{ route('opd-visits.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
