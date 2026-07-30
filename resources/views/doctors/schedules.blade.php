@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Doctor Schedules <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Manage working hours for medical staff</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Doctors</li>
                    <li class="breadcrumb-item" aria-current="page">Schedules</li>
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
            <a href="{{ route('doctors.schedules.create') }}" class="btn btn-primary">
                <i class="fa fa-plus mr-1"></i> Add New Schedule
            </a>
        </div>
    </div>
    <!-- END Quick Actions -->

    <!-- Schedules Block -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">All Schedules</h3>
            <div class="block-options">
                <form action="{{ route('doctors.schedules.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-alt" id="search" name="search" placeholder="Search doctor..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="block-content block-content-full">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Doctor</th>
                            <th>Day</th>
                            <th>Time Slot</th>
                            <th>Duration</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($schedules as $schedule)
                            <tr>
                                <td class="font-w600">
                                    <a href="{{ route('doctors.show', $schedule->doctor) }}">{{ $schedule->doctor->user->name }}</a>
                                    <div class="text-muted font-size-sm">{{ $schedule->doctor->specialization }}</div>
                                </td>
                                <td class="text-capitalize">
                                    {{ $schedule->day_of_week }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($schedule->end_time)->format('h:i A') }}
                                </td>
                                <td>
                                    {{ $schedule->slot_duration }} mins
                                </td>
                                <td>
                                    <span class="badge badge-{{ $schedule->is_available ? 'success' : 'danger' }}">
                                        {{ $schedule->is_available ? 'Active' : 'Inactive' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <form action="{{ route('doctors.schedules.destroy', $schedule) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this schedule?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-primary" title="Delete">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">
                                    <p class="font-w600 mb-2">No schedules found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
                {{ $schedules->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
    <!-- END Schedules Block -->
</div>
@endsection
