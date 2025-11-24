@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Patient Reports <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Analytics and statistics</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Reports</li>
                    <li class="breadcrumb-item active" aria-current="page">Patients</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <!-- Filters -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Filters</h3>
        </div>
        <div class="block-content">
            <form method="GET" action="{{ route('reports.patients') }}">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control form-control-alt" id="start_date" name="start_date" value="{{ $startDate }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control form-control-alt" id="end_date" name="end_date" value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-filter mr-1"></i> Apply Filters
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Overview -->
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-primary-light text-primary mx-auto">
                        <i class="fa fa-users"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Total Patients</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($totalPatients) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-success-light text-success mx-auto">
                        <i class="fa fa-user-plus"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">New Patients</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($newPatients) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-info-light text-info mx-auto">
                        <i class="fa fa-venus-mars"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Male / Female</p>
                    <p class="font-size-h2 font-w700 mb-0">
                        {{ $patientsByGender->where('gender', 'male')->first()->count ?? 0 }} / 
                        {{ $patientsByGender->where('gender', 'female')->first()->count ?? 0 }}
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-warning-light text-warning mx-auto">
                        <i class="fa fa-tint"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Blood Groups</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ $patientsByBloodGroup->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Age Distribution -->
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Age Distribution</h3>
                </div>
                <div class="block-content">
                    <canvas id="ageChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Blood Group Distribution -->
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Blood Group Distribution</h3>
                </div>
                <div class="block-content">
                    <canvas id="bloodGroupChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Patients -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Recent Patients ({{ $startDate }} to {{ $endDate }})</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Gender</th>
                            <th>Blood Group</th>
                            <th>Phone</th>
                            <th>Registered</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPatients as $patient)
                        <tr>
                            <td>{{ $patient->id }}</td>
                            <td>
                                <a href="{{ route('patients.show', $patient->id) }}">
                                    {{ $patient->first_name }} {{ $patient->last_name }}
                                </a>
                            </td>
                            <td>{{ ucfirst($patient->gender) }}</td>
                            <td>{{ $patient->blood_group ?? 'N/A' }}</td>
                            <td>{{ $patient->phone }}</td>
                            <td>{{ $patient->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No patients found in this date range</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Age Distribution Chart
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($ageRanges)) !!},
            datasets: [{
                label: 'Patients',
                data: {!! json_encode(array_values($ageRanges)) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });

    // Blood Group Chart
    const bloodCtx = document.getElementById('bloodGroupChart').getContext('2d');
    new Chart(bloodCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($patientsByBloodGroup->pluck('blood_group')) !!},
            datasets: [{
                data: {!! json_encode($patientsByBloodGroup->pluck('count')) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.5)',
                    'rgba(54, 162, 235, 0.5)',
                    'rgba(255, 206, 86, 0.5)',
                    'rgba(75, 192, 192, 0.5)',
                    'rgba(153, 102, 255, 0.5)',
                    'rgba(255, 159, 64, 0.5)',
                    'rgba(199, 199, 199, 0.5)',
                    'rgba(83, 102, 255, 0.5)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false
        }
    });
</script>
@endpush
@endsection
