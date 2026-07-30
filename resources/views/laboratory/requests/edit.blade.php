@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">{{ isset($labTestRequest) ? 'Edit' : 'New' }} Test Request</h1>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ isset($labTestRequest) ? route('lab-test-requests.update', $labTestRequest) : route('lab-test-requests.store') }}" method="POST">
                @csrf
                @if(isset($labTestRequest))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Patient <span class="text-danger">*</span></label>
                            <select class="form-control" name="patient_id" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id', $labTestRequest->patient_id ?? '') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Doctor</label>
                            <select class="form-control" name="doctor_id">
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id', $labTestRequest->doctor_id ?? '') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Lab Test <span class="text-danger">*</span></label>
                            <select class="form-control" name="lab_test_id" required>
                                <option value="">Select Test</option>
                                @foreach($labTests as $test)
                                    <option value="{{ $test->id }}" {{ old('lab_test_id', $labTestRequest->lab_test_id ?? '') == $test->id ? 'selected' : '' }}>
                                        {{ $test->name }} - ₦{{ number_format($test->price, 2) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Request Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="request_date" value="{{ old('request_date', $labTestRequest->request_date->format('Y-m-d') ?? date('Y-m-d')) }}" required>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Priority <span class="text-danger">*</span></label>
                            <select class="form-control" name="priority" required>
                                <option value="normal" {{ old('priority', $labTestRequest->priority ?? 'normal') == 'normal' ? 'selected' : '' }}>Normal</option>
                                <option value="urgent" {{ old('priority', $labTestRequest->priority ?? '') == 'urgent' ? 'selected' : '' }}>Urgent</option>
                                <option value="stat" {{ old('priority', $labTestRequest->priority ?? '') == 'stat' ? 'selected' : '' }}>STAT</option>
                            </select>
                        </div>
                    </div>
                </div>

                @if(isset($labTestRequest))
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="status">
                        <option value="pending" {{ $labTestRequest->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="in-progress" {{ $labTestRequest->status == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="completed" {{ $labTestRequest->status == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ $labTestRequest->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                @endif

                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" rows="3">{{ old('notes', $labTestRequest->notes ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ isset($labTestRequest) ? 'Update' : 'Create' }}</button>
                    <a href="{{ route('lab-test-requests.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
