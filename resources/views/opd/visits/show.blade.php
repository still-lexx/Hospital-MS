@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Visit Details</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Visit Information</h3>
            <div class="block-options">
                <span class="badge badge-primary font-size-h5">Token: {{ $opdVisit->token_number }}</span>
            </div>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Patient:</strong> {{ $opdVisit->patient->name }}</p>
                    <p><strong>Doctor:</strong> {{ $opdVisit->doctor->name }}</p>
                    <p><strong>Date:</strong> {{ $opdVisit->visit_date->format('M d, Y H:i') }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong> <span class="badge badge-info">{{ ucfirst($opdVisit->status) }}</span></p>
                    <p><strong>Reason:</strong> {{ $opdVisit->reason ?? 'N/A' }}</p>
                </div>
            </div>
        </div>
    </div>

    @if($opdVisit->vitals)
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Vital Signs</h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-3"><p><strong>Weight:</strong> {{ $opdVisit->vitals->weight }} kg</p></div>
                <div class="col-md-3"><p><strong>Height:</strong> {{ $opdVisit->vitals->height }} cm</p></div>
                <div class="col-md-3"><p><strong>Temp:</strong> {{ $opdVisit->vitals->temperature }} °C</p></div>
                <div class="col-md-3"><p><strong>Pulse:</strong> {{ $opdVisit->vitals->pulse }} bpm</p></div>
                <div class="col-md-3"><p><strong>BP:</strong> {{ $opdVisit->vitals->bp_systolic }}/{{ $opdVisit->vitals->bp_diastolic }}</p></div>
                <div class="col-md-3"><p><strong>SPO2:</strong> {{ $opdVisit->vitals->spo2 }} %</p></div>
            </div>
        </div>
    </div>
    @endif

    @if($opdVisit->consultation)
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Consultation Details</h3>
        </div>
        <div class="block-content">
            <div class="mb-3">
                <h5>Diagnosis</h5>
                <p>{{ $opdVisit->consultation->diagnosis }}</p>
            </div>
            <div class="mb-3">
                <h5>Advice</h5>
                <p>{{ $opdVisit->consultation->advice }}</p>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
