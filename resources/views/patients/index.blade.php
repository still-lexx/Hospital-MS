@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Patients Management <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">List of all patients</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Patients</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
   <!-- Quick Overview -->
   <div class="row">
        <div class="col-6 col-lg-3">
            <a class="block block-rounded block-link-shadow text-center" href="{{route('patients.create')}}">
                <div class="block-content block-content-full">
                    <div class="font-size-h2 text-success">
                        <i class="fa fa-plus"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-success mb-0">
                        Add New
                    </p>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="font-size-h2 text-danger">{{ $stats['admitted'] }}</div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-danger mb-0">
                        Admitted
                    </p>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="font-size-h2 text-dark">{{ $stats['new'] }}</div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">
                        New
                    </p>
                </div>
            </a>
        </div>
        <div class="col-6 col-lg-3">
            <a class="block block-rounded block-link-shadow text-center" href="javascript:void(0)">
                <div class="block-content block-content-full">
                    <div class="font-size-h2 text-dark">{{ $stats['total'] }}</div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">
                        All Patients
                    </p>
                </div>
            </a>
        </div>
    </div>
    <!-- END Quick Overview -->

    <!-- All Patients -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">All Patients</h3>
            <div class="block-options">
                <div class="dropdown">
                    <button type="button" class="btn-block-option" id="dropdown-ecom-filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filters <i class="fa fa-angle-down ml-1"></i>
                    </button>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdown-ecom-filters">
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('patients.index', array_merge(request()->query(), ['status' => 'new'])) }}">
                            New
                            <span class="badge badge-success badge-pill">{{ $stats['new'] }}</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('patients.index', array_merge(request()->query(), ['status' => 'admitted'])) }}">
                            Admitted
                            <span class="badge badge-danger badge-pill">{{ $stats['admitted'] }}</span>
                        </a>
                        <a class="dropdown-item d-flex align-items-center justify-content-between" href="{{ route('patients.index', array_merge(request()->query(), ['status' => 'all'])) }}">
                            All
                            <span class="badge badge-primary badge-pill">{{ $stats['total'] }}</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="block-content">
            <!-- Search Form -->
            <form action="{{ route('patients.index') }}" method="GET">
                <div class="form-group">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-alt" id="one-ecom-products-search" name="search" placeholder="Search all patients.." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text bg-body border-0">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- END Search Form -->

            <!-- All Patients Table -->
            <div class="table-responsive">
                <table class="table table-borderless table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="d-none d-md-table-cell">Gender</th>
                            <th class="d-none d-md-table-cell">Age</th>
                            <th class="d-none d-md-table-cell">Phone</th>
                            <th class="d-none d-xl-table-cell">Ward</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($patients as $patient)
                        <tr>
                            <td class="font-w600">
                                {{ $patient->name }}
                            </td>
                            <td class="d-none d-md-table-cell">
                                <span class="badge badge-{{ $patient->gender == 'male' ? 'primary' : 'danger' }}">
                                    {{ ucfirst($patient->gender) }}
                                </span>
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ $patient->date_of_birth ? \Carbon\Carbon::parse($patient->date_of_birth)->age . ' years' : 'N/A' }}
                            </td>
                            <td class="d-none d-md-table-cell">
                                {{ $patient->phone ?? 'N/A' }}
                            </td>
                            <td class="d-none d-xl-table-cell">
                                {{ $patient->ward->name ?? 'Not Assigned' }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('patients.show', $patient) }}" class="btn btn-sm btn-primary" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                <a href="{{ route('patients.edit', $patient) }}" class="btn btn-sm btn-secondary" title="Edit">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                @if(auth()->user()->isAdmin())
                                <form id="delete-form-{{ $patient->id }}" action="{{ route('patients.destroy', $patient) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" onclick="confirmDelete(event, 'delete-form-{{ $patient->id }}')" class="btn btn-sm btn-danger" title="Delete">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <p class="text-muted">No patients found.</p>
                                <a href="{{ route('patients.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus mr-1"></i> Add First Patient
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- END All Patients Table -->

            <!-- Pagination -->
            @if($patients->hasPages())
            <div class="d-flex justify-content-end mt-2">
                {{ $patients->links() }}
            </div>
            @endif
            <!-- END Pagination -->
        </div>
    </div>
    <!-- END All Patients -->
</div>
@endsection