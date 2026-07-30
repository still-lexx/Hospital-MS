@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Consultations Queue</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th>Token</th>
                        <th>Patient</th>
                        <th>Vitals</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visits as $visit)
                    <tr>
                        <td><span class="badge badge-primary">{{ $visit->token_number }}</span></td>
                        <td>{{ $visit->patient->name }}</td>
                        <td>
                            @if($visit->vitals)
                                <small>
                                    BP: {{ $visit->vitals->bp_systolic }}/{{ $visit->vitals->bp_diastolic }}<br>
                                    Temp: {{ $visit->vitals->temperature }}°C<br>
                                    Pulse: {{ $visit->vitals->pulse }}
                                </small>
                            @else
                                <span class="text-muted">Not Recorded</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge badge-{{ $visit->status == 'in-consultation' ? 'warning' : 'info' }}">
                                {{ ucfirst($visit->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('opd-consultations.create', $visit) }}" class="btn btn-sm btn-success">
                                <i class="fa fa-stethoscope"></i> Consult
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No patients waiting for consultation.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $visits->links() }}
        </div>
    </div>
</div>
@endsection
