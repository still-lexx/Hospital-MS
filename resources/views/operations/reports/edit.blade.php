@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Edit Surgery Report</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('surgery-reports.update', $surgeryReport) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="alert alert-info">
                    <strong>Surgery:</strong> {{ $surgeryReport->surgery->surgery_name }} - {{ $surgeryReport->surgery->patient->name }}
                </div>

                <div class="form-group">
                    <label>Report Date <span class="text-danger">*</span></label>
                    <input type="datetime-local" class="form-control" name="report_date" value="{{ $surgeryReport->report_date->format('Y-m-d\TH:i') }}" required>
                </div>

                <div class="form-group">
                    <label>Pre-Operative Diagnosis <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="pre_operative_diagnosis" rows="3" required>{{ $surgeryReport->pre_operative_diagnosis }}</textarea>
                </div>

                <div class="form-group">
                    <label>Post-Operative Diagnosis</label>
                    <textarea class="form-control" name="post_operative_diagnosis" rows="3">{{ $surgeryReport->post_operative_diagnosis }}</textarea>
                </div>

                <div class="form-group">
                    <label>Procedure Details <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="procedure_details" rows="5" required>{{ $surgeryReport->procedure_details }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Complications</label>
                            <textarea class="form-control" name="complications" rows="3">{{ $surgeryReport->complications }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Blood Loss</label>
                            <input type="text" class="form-control" name="blood_loss" value="{{ $surgeryReport->blood_loss }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Report</button>
                    <a href="{{ route('surgery-reports.show', $surgeryReport) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
