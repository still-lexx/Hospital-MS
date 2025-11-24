@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Financial Reports <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Revenue and billing analytics</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Reports</li>
                    <li class="breadcrumb-item active" aria-current="page">Financial</li>
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
            <form method="GET" action="{{ route('reports.financial') }}">
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="start_date">Start Date</label>
                            <input type="date" class="form-control form-control-alt" id="start_date" name="start_date" value="{{ $startDate }}">
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="form-group">
                            <label for="end_date">End Date</label>
                            <input type="date" class="form-control form-control-alt" id="end_date" name="end_date" value="{{ $endDate }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fa fa-filter mr-1"></i> Apply
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Financial Overview -->
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-success-light text-success mx-auto">
                        <i class="fa fa-dollar-sign"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Estimated Revenue</p>
                    <p class="font-size-h2 font-w700 mb-0">₦{{ number_format($estimatedRevenue) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-primary-light text-primary mx-auto">
                        <i class="fa fa-calendar-check"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Total Appointments</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($totalAppointments) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-info-light text-info mx-auto">
                        <i class="fa fa-check-circle"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Completed</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($completedAppointments) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-danger-light text-danger mx-auto">
                        <i class="fa fa-times-circle"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Cancelled</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($cancelledAppointments) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row">
        <!-- Monthly Revenue Trend -->
        <div class="col-md-8">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Monthly Revenue Trend (Last 6 Months)</h3>
                </div>
                <div class="block-content">
                    <canvas id="revenueChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Revenue by Specialization -->
        <div class="col-md-4">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Revenue by Specialization</h3>
                </div>
                <div class="block-content">
                    <canvas id="departmentChart" height="250"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Specialization Revenue Table -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Specialization Performance</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Specialization</th>
                            <th>Completed Appointments</th>
                            <th>Estimated Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($revenueBySpecialization as $spec)
                        <tr>
                            <td>{{ $spec->specialization }}</td>
                            <td>{{ number_format($spec->count) }}</td>
                            <td>₦{{ number_format($spec->count * 1000) }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center">No data available for this period</td>
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
    // Monthly Revenue Trend Chart
    const revenueCtx = document.getElementById('revenueChart').getContext('2d');
    new Chart(revenueCtx, {
        type: 'line',
        data: {
            labels: {!! json_encode(array_column($monthlyTrend, 'month')) !!},
            datasets: [{
                label: 'Completed Appointments',
                data: {!! json_encode(array_column($monthlyTrend, 'count')) !!},
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                borderColor: 'rgba(75, 192, 192, 1)',
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

    // Specialization Revenue Chart
    const deptCtx = document.getElementById('departmentChart').getContext('2d');
    new Chart(deptCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($revenueBySpecialization->pluck('specialization')) !!},
            datasets: [{
                data: {!! json_encode($revenueBySpecialization->pluck('count')) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.7)',
                    'rgba(54, 162, 235, 0.7)',
                    'rgba(255, 206, 86, 0.7)',
                    'rgba(75, 192, 192, 0.7)',
                    'rgba(153, 102, 255, 0.7)',
                    'rgba(255, 159, 64, 0.7)'
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
