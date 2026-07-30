@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Surgery Report</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Surgery Information</h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Patient:</strong> {{ $surgeryReport->surgery->patient->name }}</p>
                    <p><strong>Surgery:</strong> {{ $surgeryReport->surgery->surgery_name }}</p>
                    <p><strong>Surgeon:</strong> {{ $surgeryReport->surgery->doctor->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Surgery Date:</strong> {{ $surgeryReport->surgery->surgery_date->format('M d, Y') }}</p>
                    <p><strong>OT Room:</strong> {{ $surgeryReport->surgery->otRoom->room_name ?? 'N/A' }}</p>
                    <p><strong>Report Date:</strong> {{ $surgeryReport->report_date->format('M d, Y H:i') }}</p>
                    <p><strong>Reported By:</strong> {{ $surgeryReport->reporter->name }}</p>
                </div>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Medical Report</h3>
        </div>
        <div class="block-content">
            <div class="mb-3">
                <h5>Pre-Operative Diagnosis</h5>
                <p>{{ $surgeryReport->pre_operative_diagnosis }}</p>
            </div>

            @if($surgeryReport->post_operative_diagnosis)
            <div class="mb-3">
                <h5>Post-Operative Diagnosis</h5>
                <p>{{ $surgeryReport->post_operative_diagnosis }}</p>
            </div>
            @endif

            <div class="mb-3">
                <h5>Procedure Details</h5>
                <p style="white-space: pre-line;">{{ $surgeryReport->procedure_details }}</p>
            </div>

            @if($surgeryReport->complications)
            <div class="mb-3">
                <h5>Complications</h5>
                <p>{{ $surgeryReport->complications }}</p>
            </div>
            @endif

            @if($surgeryReport->blood_loss)
            <div class="mb-3">
                <h5>Blood Loss</h5>
                <p>{{ $surgeryReport->blood_loss }}</p>
            </div>
            @endif
        </div>
        <div class="block-content block-content-full block-content-sm bg-body-light">
            <a href="{{ route('surgery-reports.edit', $surgeryReport) }}" class="btn btn-warning">
                <i class="fa fa-edit"></i> Edit Report
            </a>
            <a href="{{ route('surgery-reports.index') }}" class="btn btn-secondary">Back to Reports</a>
        </div>
    </div>
</div>
@endsection
