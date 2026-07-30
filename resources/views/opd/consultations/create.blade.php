@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Consultation: {{ $visit->patient->name }}</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <span class="badge badge-primary font-size-h5">Token: {{ $visit->token_number }}</span>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <!-- Patient Vitals Sidebar -->
        <div class="col-md-4">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Vital Signs</h3>
                </div>
                <div class="block-content">
                    @if($visit->vitals)
                    <table class="table table-striped table-sm">
                        <tr><td>Weight</td><td>{{ $visit->vitals->weight }} kg</td></tr>
                        <tr><td>Height</td><td>{{ $visit->vitals->height }} cm</td></tr>
                        <tr><td>BP</td><td>{{ $visit->vitals->bp_systolic }}/{{ $visit->vitals->bp_diastolic }}</td></tr>
                        <tr><td>Temp</td><td>{{ $visit->vitals->temperature }} °C</td></tr>
                        <tr><td>Pulse</td><td>{{ $visit->vitals->pulse }} bpm</td></tr>
                        <tr><td>SPO2</td><td>{{ $visit->vitals->spo2 }} %</td></tr>
                    </table>
                    @else
                    <p class="text-muted">No vitals recorded.</p>
                    @endif
                    
                    <div class="mt-3">
                        <h5>Reason for Visit</h5>
                        <p>{{ $visit->reason ?? 'Not specified' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Consultation Form -->
        <div class="col-md-8">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Clinical Notes</h3>
                </div>
                <div class="block-content">
                    <form action="{{ route('opd-consultations.store', $visit) }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label>Symptoms <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="symptoms" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Examination Notes</label>
                            <textarea class="form-control" name="examination_notes" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Diagnosis <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="diagnosis" rows="2" required></textarea>
                        </div>

                        <div class="form-group">
                            <label>Advice / Prescription Note</label>
                            <textarea class="form-control" name="advice" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label>Next Visit Date</label>
                            <input type="date" class="form-control" name="next_visit_date">
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Complete Consultation</button>
                            <a href="{{ route('opd-consultations.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
