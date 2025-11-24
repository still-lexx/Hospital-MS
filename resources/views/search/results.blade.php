@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Search Results <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Results for "{{ $query }}"</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Search</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <!-- Patients Results -->
    @if($patients->count() > 0)
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                <i class="fa fa-user-injured text-primary mr-2"></i> Patients ({{ $patients->count() }})
            </h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-borderless table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Gender</th>
                            <th>Address</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($patients as $patient)
                        <tr>
                            <td class="font-w600">{{ $patient->name }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>
                                <span class="badge badge-{{ $patient->gender == 'male' ? 'primary' : 'danger' }}">
                                    {{ ucfirst($patient->gender) }}
                                </span>
                            </td>
                            <td>{{ Str::limit($patient->address, 40) }}</td>
                            <td class="text-center">
                                <a href="{{ route('patients.show', $patient->id) }}" class="btn btn-sm btn-primary" title="View">
                                    <i class="fa fa-eye"></i>
                           </a>
                                <a href="{{ route('patients.edit', $patient->id) }}" class="btn btn-sm btn-secondary" title="Edit">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <form id="delete-form-{{ $patient->id }}" action="{{ route('patients.destroy', $patient->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(event, 'delete-form-{{ $patient->id }}')" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Pagination -->
    <nav aria-label="Photos Search Navigation">
        <ul class="pagination pagination-sm justify-content-end mt-2">
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" tabindex="-1" aria-label="Previous">
                    Prev
                </a>
            </li>
            <li class="page-item active">
                <a class="page-link" href="javascript:void(0)">1</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)">2</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)">3</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)">4</a>
            </li>
            <li class="page-item">
                <a class="page-link" href="javascript:void(0)" aria-label="Next">
                    Next
                </a>
            </li>
        </ul>
    </nav>
    <!-- END Pagination -->
    @endif

    <!-- Doctors Results -->
    @if(count($doctors) > 0)
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                <i class="fa fa-user-md text-success mr-2"></i> Doctors ({{ count($doctors) }})
            </h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-borderless table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Specialization</th>
                            <th>Phone</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($doctors as $doctor)
                        <tr>
                            <td class="font-w600">{{ $doctor->user->name ?? 'N/A' }}</td>
                            <td>{{ $doctor->specialization ?? 'N/A' }}</td>
                            <td>{{ $doctor->phone ?? 'N/A' }}</td>
                            <td class="text-center">
                                <a href="{{ route('doctors.show', $doctor->id) }}" class="btn btn-sm btn-primary" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Appointments Results -->
    @if(count($appointments) > 0)
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">
                <i class="fa fa-calendar text-info mr-2"></i> Appointments ({{ count($appointments) }})
            </h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-borderless table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Patient</th>
                            <th>Doctor</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($appointments as $appointment)
                        <tr>
                            <td class="font-w600">{{ $appointment->patient->name ?? 'N/A' }}</td>
                            <td>{{ $appointment->doctor->name ?? 'N/A' }}</td>
                            <td>{{ $appointment->appointment_date ?? 'N/A' }}</td>
                            <td>
                                <span class="badge badge-primary">{{ $appointment->status ?? 'Scheduled' }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('appointments.show', $appointment->id) }}" class="btn btn-sm btn-primary" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- No Results -->
    @if($patients->count() == 0 && count($doctors) == 0 && count($appointments) == 0)
    <div class="block block-rounded">
        <div class="block-content text-center py-5">
            <i class="fa fa-search fa-3x text-muted mb-3"></i>
            <h3 class="text-muted">No results found</h3>
            <p class="text-muted">No results found for "{{ $query }}". Try searching with different keywords.</p>
            <a href="{{ route('dashboard') }}" class="btn btn-primary mt-3">
                <i class="fa fa-arrow-left mr-1"></i> Back to Dashboard
            </a>
        </div>
    </div>
    @endif
</div>
@endsection
