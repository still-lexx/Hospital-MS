@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">New Patient Admission</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('ipd-admissions.store') }}" method="POST">
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
                    <label>Select Bed <span class="text-danger">*</span></label>
                    <select class="form-control" name="bed_id" required>
                        <option value="">Select Ward & Bed</option>
                        @foreach($wards as $ward)
                            <optgroup label="{{ $ward->name }} ({{ $ward->type }})">
                                @foreach($ward->beds as $bed)
                                    <option value="{{ $bed->id }}">
                                        Bed: {{ $bed->bed_number }} - ₦{{ number_format($bed->daily_charge, 2) }}/day
                                    </option>
                                @endforeach
                            </optgroup>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Admission Date <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="admission_date" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Deposit Amount (₦)</label>
                            <input type="number" step="0.01" class="form-control" name="deposit_amount">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Reason for Admission <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="reason" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Admit Patient</button>
                    <a href="{{ route('ipd-admissions.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
