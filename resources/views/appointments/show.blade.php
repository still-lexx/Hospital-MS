@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Appointment Details <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">View appointment information</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('appointments.index') }}">Appointments</a></li>
                    <li class="breadcrumb-item" aria-current="page">Details</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">#{{ $appointment->id }} - {{ ucfirst($appointment->appointment_type) }}</h3>
            <div class="block-options">
                <a href="{{ route('appointments.edit', $appointment) }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-pencil-alt mr-1"></i> Edit
                </a>
                <form action="{{ route('appointments.destroy', $appointment) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to cancel this appointment?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                        <i class="fa fa-times mr-1"></i> Cancel
                    </button>
                </form>
            </div>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <div class="block block-bordered">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Patient Information</h3>
                        </div>
                        <div class="block-content">
                            <p><strong>Name:</strong> <a href="{{ route('patients.show', $appointment->patient) }}">{{ $appointment->patient->name }}</a></p>
                            <p><strong>Phone:</strong> {{ $appointment->patient->phone }}</p>
                            <p><strong>Gender:</strong> {{ ucfirst($appointment->patient->gender) }}</p>
                            <p><strong>Age:</strong> {{ $appointment->patient->date_of_birth ? \Carbon\Carbon::parse($appointment->patient->date_of_birth)->age . ' years' : 'N/A' }}</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="block block-bordered">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Doctor Information</h3>
                        </div>
                        <div class="block-content">
                            <p><strong>Name:</strong> {{ $appointment->doctor->user->name ?? $appointment->doctor->id }}</p>
                            <p><strong>Specialization:</strong> {{ $appointment->doctor->specialization ?? 'General' }}</p>
                            <p><strong>Department:</strong> {{ $appointment->doctor->department->name ?? 'N/A' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="block block-bordered">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Appointment Details</h3>
                </div>
                <div class="block-content">
                    <div class="row mb-3">
                        <div class="col-md-3 font-w600">Date & Time</div>
                        <div class="col-md-9">
                            {{ $appointment->appointment_date->format('F d, Y') }} at {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-w600">Status</div>
                        <div class="col-md-9">
                            <span class="badge badge-{{ $appointment->status == 'confirmed' ? 'success' : ($appointment->status == 'cancelled' ? 'danger' : 'primary') }}">
                                {{ ucfirst($appointment->status) }}
                            </span>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-w600">Reason</div>
                        <div class="col-md-9">
                            {{ $appointment->reason ?? 'No reason provided.' }}
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 font-w600">Notes</div>
                        <div class="col-md-9">
                            {{ $appointment->notes ?? 'No notes.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
