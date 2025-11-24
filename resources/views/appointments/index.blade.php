@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Appointments <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Manage your appointments</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Appointments</li>
                    <li class="breadcrumb-item" aria-current="page">List</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('appointments.create') }}" class="btn btn-primary">
                <i class="fa fa-plus mr-1"></i> Book Appointment
            </a>
        </div>
    </div>
    <!-- END Quick Actions -->

    <!-- Appointments Block -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <ul class="nav nav-tabs nav-tabs-block" role="tablist">
                <li class="nav-item">
                    <a class="nav-link {{ !request('view') || request('view') != 'history' ? 'active' : '' }}" href="{{ route('appointments.index') }}">Upcoming</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('view') == 'history' ? 'active' : '' }}" href="{{ route('appointments.index', ['view' => 'history']) }}">History</a>
                </li>
            </ul>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Date & Time</th>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Type</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($appointments as $appointment)
                            <tr>
                                <td>
                                    <div class="font-w600">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                    <div class="font-size-sm text-muted">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                                </td>
                                <td>
                                    <a href="{{ route('patients.show', $appointment->patient) }}">{{ $appointment->patient->name }}</a>
                                </td>
                                <td>
                                    {{ $appointment->doctor->user->name ?? $appointment->doctor->id }}
                                </td>
                                <td>
                                    <span class="badge badge-info">{{ ucfirst($appointment->appointment_type) }}</span>
                                </td>
                                <td>
                                    @php
                                        $statusClass = 'secondary';
                                        switch($appointment->status) {
                                            case 'confirmed': $statusClass = 'success'; break;
                                            case 'scheduled': $statusClass = 'primary'; break;
                                            case 'cancelled': $statusClass = 'danger'; break;
                                            case 'completed': $statusClass = 'info'; break;
                                        }
                                    @endphp
                                    <span class="badge badge-{{ $statusClass }}">{{ ucfirst($appointment->status) }}</span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-primary" title="View">
                                            <i class="fa fa-fw fa-eye"></i>
                                        </a>
                                        <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-primary" title="Edit">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <p class="font-w600 mb-2">No appointments found.</p>
                                    <a href="{{ route('appointments.create') }}" class="btn btn-sm btn-primary">Book First Appointment</a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $appointments->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <!-- END Appointments Block -->
</div>
@endsection
