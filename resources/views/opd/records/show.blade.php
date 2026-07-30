@extends('layouts.app')

@section('content')
<div class="bg-body-light d-print-none">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Medical Record Details</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <button onclick="window.print()" class="btn btn-primary">
                    <i class="fa fa-print"></i> Print Record
                </button>
                <a href="{{ route('opd-records.index') }}" class="btn btn-secondary">Back</a>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">OPD Visit Summary</h3>
            <div class="block-options">
                <span class="text-muted">{{ $visit->visit_date->format('d M Y, h:i A') }}</span>
            </div>
        </div>
        <div class="block-content">
            <!-- Patient & Doctor Info -->
            <div class="row mb-4">
                <div class="col-6">
                    <h4 class="h5 mb-1">Patient Details</h4>
                    <address>
                        <strong>{{ $visit->patient->name }}</strong><br>
                        {{ $visit->patient->address ?? 'No Address' }}<br>
                        Phone: {{ $visit->patient->phone ?? 'N/A' }}<br>
                        Age/Gender: {{ $visit->patient->age ?? 'N/A' }} / {{ ucfirst($visit->patient->gender ?? 'N/A') }}
                    </address>
                </div>
                <div class="col-6 text-right">
                    <h4 class="h5 mb-1">Doctor Details</h4>
                    <address>
                        <strong>Dr. {{ $visit->doctor->name }}</strong><br>
                        {{ $visit->doctor->department ?? 'General Medicine' }}<br>
                        OPD Token: #{{ $visit->token_number }}
                    </address>
                </div>
            </div>

            <hr>

            <!-- Vitals -->
            @if($visit->vitals)
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="h5">Vital Signs</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm">
                            <thead class="thead-light">
                                <tr>
                                    <th>BP</th>
                                    <th>Pulse</th>
                                    <th>Temp</th>
                                    <th>SPO2</th>
                                    <th>Weight</th>
                                    <th>Height</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $visit->vitals->bp_systolic }}/{{ $visit->vitals->bp_diastolic }} mmHg</td>
                                    <td>{{ $visit->vitals->pulse }} bpm</td>
                                    <td>{{ $visit->vitals->temperature }} °C</td>
                                    <td>{{ $visit->vitals->spo2 }} %</td>
                                    <td>{{ $visit->vitals->weight }} kg</td>
                                    <td>{{ $visit->vitals->height }} cm</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Clinical Notes -->
            @if($visit->consultation)
            <div class="row mb-4">
                <div class="col-12">
                    <h4 class="h5 bg-body-light p-2 rounded">Diagnosis</h4>
                    <p class="pl-2">{{ $visit->consultation->diagnosis }}</p>

                    @if($visit->consultation->symptoms)
                    <h4 class="h5 bg-body-light p-2 rounded mt-3">Symptoms</h4>
                    <p class="pl-2">{{ $visit->consultation->symptoms }}</p>
                    @endif

                    @if($visit->consultation->examination_notes)
                    <h4 class="h5 bg-body-light p-2 rounded mt-3">Examination Notes</h4>
                    <p class="pl-2">{{ $visit->consultation->examination_notes }}</p>
                    @endif

                    @if($visit->consultation->advice)
                    <h4 class="h5 bg-body-light p-2 rounded mt-3">Advice / Prescription</h4>
                    <p class="pl-2" style="white-space: pre-line;">{{ $visit->consultation->advice }}</p>
                    @endif

                    @if($visit->consultation->next_visit_date)
                    <div class="alert alert-info mt-3">
                        <strong>Next Follow-up:</strong> {{ $visit->consultation->next_visit_date->format('d M Y') }}
                    </div>
                    @endif
                </div>
            </div>
            @endif
            
            <div class="row mt-5 d-none d-print-block">
                <div class="col-12 text-right">
                    <p class="mb-0">_______________________</p>
                    <p>Doctor's Signature</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
