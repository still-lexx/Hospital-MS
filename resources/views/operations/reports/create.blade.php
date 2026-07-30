@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">New Surgery Report</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('surgery-reports.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Surgery <span class="text-danger">*</span></label>
                    <select class="form-control" name="surgery_id" required>
                        <option value="">Select Completed Surgery</option>
                        @foreach($surgeries as $surgery)
                            <option value="{{ $surgery->id }}">
                                {{ $surgery->surgery_name }} - {{ $surgery->patient->name }} ({{ $surgery->surgery_date->format('M d, Y') }})
                            </option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Only completed surgeries without reports are shown</small>
                </div>

                <div class="form-group">
                    <label>Report Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" name="report_date" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                </div>

                <div class="form-group">
                    <label>Pre-Operative Diagnosis <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="pre_operative_diagnosis" rows="3" required></textarea>
                </div>

                <div class="form-group">
                    <label>Post-Operative Diagnosis</label>
                    <textarea class="form-control" name="post_operative_diagnosis" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <label>Procedure Details <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="procedure_details" rows="5" required></textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Complications</label>
                            <textarea class="form-control" name="complications" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Blood Loss</label>
                            <input type="text" class="form-control" name="blood_loss" placeholder="e.g., 250ml">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Report</button>
                    <a href="{{ route('surgery-reports.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
