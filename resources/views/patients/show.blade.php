@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Patient Details <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">View patient information</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('patients.index') }}">Patients</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $patient->name }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <!-- Patient Details Block -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Patient Information</h3>
            <div class="block-options">
                <button type="button" class="btn btn-sm btn-secondary" onclick="window.print()">
                    <i class="fa fa-print mr-1"></i> Print
                </button>
                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-pencil-alt mr-1"></i> Edit
                </a>
            </div>
        </div>
        <div class="block-content">
            <div class="row">
                <!-- Photo Section -->
                @if($patient->photo)
                <div class="col-md-3 text-center mb-4">
                    <img src="{{ asset('storage/' . $patient->photo) }}" alt="{{ $patient->name }}" class="img-fluid rounded">
                </div>
                @endif
                
                <!-- Details Section -->
                <div class="{{ $patient->photo ? 'col-md-9' : 'col-md-12' }}">
                    <div class="row">
                        <div class="col-md-6">
                            <h4 class="mb-3">Personal Information</h4>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="font-w600" style="width: 40%;">Name:</td>
                                        <td>{{ $patient->name }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Gender:</td>
                                        <td>
                                            <span class="badge badge-{{ $patient->gender == 'Male' ? 'primary' : 'danger' }}">
                                                {{ ucfirst($patient->gender) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Date of Birth:</td>
                                        <td>{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->format('M d, Y') : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Age:</td>
                                        <td>{{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->age . ' years' : 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Blood Group:</td>
                                        <td><span class="badge badge-info">{{ $patient->blood_group ?? 'N/A' }}</span></td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Genotype:</td>
                                        <td>{{ $patient->genotype ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Marital Status:</td>
                                        <td>{{ ucfirst($patient->marital_status) ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="col-md-6">
                            <h4 class="mb-3">Contact Information</h4>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="font-w600" style="width: 40%;">Phone:</td>
                                        <td>{{ $patient->phone ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Address:</td>
                                        <td>{{ $patient->address ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Emergency Contact:</td>
                                        <td>{{ $patient->emergency_contact ?? 'N/A' }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            <h4 class="mb-3 mt-4">Medical Information</h4>
                            <table class="table table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="font-w600" style="width: 40%;">Ward:</td>
                                        <td>{{ $patient->ward->name ?? 'Not Assigned' }}</td>
                                    </tr>
                                    <tr>
                                        <td class="font-w600">Admission Status:</td>
                                        <td>
                                            @if($patient->admitted)
                                                <span class="badge badge-danger">Admitted</span>
                                            @else
                                                <span class="badge badge-success">Not Admitted</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if($patient->allergies)
                                    <tr>
                                        <td class="font-w600">Allergies:</td>
                                        <td><span class="badge badge-warning">{{ $patient->allergies }}</span></td>
                                    </tr>
                                    @endif
                                    @if($patient->conditions)
                                    <tr>
                                        <td class="font-w600">Conditions:</td>
                                        <td>{{ $patient->conditions }}</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Action Buttons -->
            <div class="row">
                <div class="block-content block-content-full">
                    <a href="{{ route('patients.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left mr-1"></i> Back to List
                    </a>
                    <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-primary">
                        <i class="fa fa-pencil-alt mr-1"></i> Edit Patient
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- END Patient Details Block -->
</div>
@endsection
