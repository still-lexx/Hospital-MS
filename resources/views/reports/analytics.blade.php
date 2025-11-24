@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Analytics Dashboard <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Comprehensive hospital insights</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Reports</li>
                    <li class="breadcrumb-item active" aria-current="page">Analytics</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <!-- Key Performance Indicators -->
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
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($kpis['total_patients']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-success-light text-success mx-auto">
                        <i class="fa fa-user-md"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Total Doctors</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($kpis['total_doctors']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-info-light text-info mx-auto">
                        <i class="fa fa-building"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Departments</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($kpis['total_departments']) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-warning-light text-warning mx-auto">
                        <i class="fa fa-calendar-day"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Today's Appointments</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($kpis['today_appointments']) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional KPIs -->
    <div class="row">
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-content block-content-full">
                    <div class="row">
                        <div class="col-6 py-3 border-right">
                            <div class="text-center">
                                <p class="font-w600 font-size-sm text-muted mb-2">Pending Appointments</p>
                                <p class="font-size-h3 font-w700 text-warning mb-0">{{ number_format($kpis['pending_appointments']) }}</p>
                            </div>
                        </div>
                        <div class="col-6 py-3">
                            <div class="text-center">
                                <p class="font-w600 font-size-sm text-muted mb-2">Completed This Month</p>
                                <p class="font-size-h3 font-w700 text-success mb-0">{{ number_format($kpis['completed_appointments_month']) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Appointment Status</h3>
                </div>
                <div class="block-content">
                    <canvas id="statusChart" height="100"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Patient Growth Chart -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Patient Growth (Last 12 Months)</h3>
        </div>
        <div class="block-content">
            <canvas id="growthChart" height="80"></canvas>
        </div>
    </div>

    <!-- Department and Doctor Performance -->
    <div class="row">
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Top Specializations by Doctors</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Specialization</th>
                                    <th>Doctors</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($topSpecializations as $spec)
                                <tr>
                                    <td>{{ $spec->specialization }}</td>
                                    <td><span class="badge badge-primary">{{ $spec->doctors_count }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">No specializations found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Doctor Utilization (This Month)</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Doctor</th>
                                    <th>Appointments</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($doctorUtilization as $doctor)
                                <tr>
                                    <td>Dr. {{ $doctor->name }}</td>
                                    <td><span class="badge badge-success">{{ $doctor->appointments_count }}</span></td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="text-center">No data available</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>
<script>
    // Patient Growth Chart
    const growthCtx = document.getElementById('growthChart').getContext('2d');
    new Chart(growthCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($patientGrowth, 'month')) !!},
            datasets: [{
                label: 'New Patients',
                data: {!! json_encode(array_column($patientGrowth, 'count')) !!},
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
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

    // Appointment Status Chart
    const statusCtx = document.getElementById('statusChart').getContext('2d');
    new Chart(statusCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($appointmentStatus->pluck('status')->map(fn($s) => ucfirst($s))) !!},
            datasets: [{
                data: {!! json_encode($appointmentStatus->pluck('count')) !!},
                backgroundColor: [
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
</script>
@endpush
@endsection
