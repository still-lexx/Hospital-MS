@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">OPD Visits Queue</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('opd-visits.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Registration
                </a>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th>Token</th>
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Status</th>
                        <th>Vitals</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($visits as $visit)
                    <tr>
                        <td><span class="badge badge-primary">{{ $visit->token_number }}</span></td>
                        <td>{{ $visit->visit_date->format('M d, H:i') }}</td>
                        <td>{{ $visit->patient->name }}</td>
                        <td>{{ $visit->doctor->name }}</td>
                        <td>
                            <span class="badge badge-{{ $visit->status == 'completed' ? 'success' : ($visit->status == 'in-consultation' ? 'warning' : 'info') }}">
                                {{ ucfirst($visit->status) }}
                            </span>
                        </td>
                        <td>
                            @if($visit->vitals)
                                <i class="fa fa-check text-success" title="Vitals Recorded"></i>
                            @else
                                <i class="fa fa-times text-danger" title="No Vitals"></i>
                            @endif
                        </td>
                        <td class="text-center">
                            <a href="{{ route('opd-visits.show', $visit) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No active visits found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $visits->links() }}
        </div>
    </div>
</div>
@endsection
