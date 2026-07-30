@extends('layouts.app')

@section('content')
                <!-- Hero -->
                <div class="bg-body-light">
                    <div class="content content-full">
                        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center py-2 text-center text-sm-left">
                            <div class="flex-sm-fill">
                                <h1 class="h3 font-w700 mb-2">
                                    Main Dashboard
                                </h1>
                                <h2 class="h6 font-w500 text-muted mb-0">
                                    Welcome <a class="font-w600" href="javascript:void(0)">{{ Auth::user()->name }}</a>, everything looks great.
                                </h2>
                            </div>
                            <div class="mt-3 mt-sm-0 ml-sm-3">
                                <button type="button" class="btn btn-sm btn-alt-primary">
                                    <i class="fa fa-cog"></i>
                                </button>
                                <div class="dropdown d-inline-block">
                                    <button type="button" class="btn btn-sm btn-alt-primary" id="dropdown-analytics-overview" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-fw fa-calendar-alt"></i>
                                        Last 30 days
                                        <i class="fa fa-fw fa-angle-down"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right font-size-sm" aria-labelledby="dropdown-analytics-overview">
                                        <a class="dropdown-item font-w500" href="javascript:void(0)">This Week</a>
                                        <a class="dropdown-item font-w500" href="javascript:void(0)">Previous Week</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item font-w500" href="javascript:void(0)">This Month</a>
                                        <a class="dropdown-item font-w500" href="javascript:void(0)">Previous Month</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END Hero -->

                <!-- Page Content -->
                <div class="content">
                    <!-- Overview -->
                    <div class="row row-deck">
                        <div class="col-sm-6 col-xl-3">
                            <!-- Total Patients -->
                            <div class="block block-rounded d-flex flex-column">
                                <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="font-size-h2 font-w700">{{ $stats['total_patients'] }}</dt>
                                        <dd class="text-muted mb-0">Total Patients</dd>
                                    </dl>
                                    <div class="item item-rounded bg-body">
                                        <i class="fa fa-users font-size-h3 text-primary"></i>
                                    </div>
                                </div>
                                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                                    <a class="font-w500 d-flex align-items-center" href="{{ route('patients.index') }}">
                                        View all patients
                                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Total Patients -->
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <!-- Admitted Patients -->
                            <div class="block block-rounded d-flex flex-column">
                                <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="font-size-h2 font-w700">{{ $stats['admitted_patients'] }}</dt>
                                        <dd class="text-muted mb-0">Admitted Patients</dd>
                                    </dl>
                                    <div class="item item-rounded bg-body">
                                        <i class="fa fa-bed font-size-h3 text-success"></i>
                                    </div>
                                </div>
                                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                                    <a class="font-w500 d-flex align-items-center" href="{{ route('wards.index') }}">
                                        View IPD wards
                                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Admitted Patients -->
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <!-- Today's Appointments -->
                            <div class="block block-rounded d-flex flex-column">
                                <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="font-size-h2 font-w700">{{ $stats['todays_appointments'] }}</dt>
                                        <dd class="text-muted mb-0">Today's Appointments</dd>
                                    </dl>
                                    <div class="item item-rounded bg-body">
                                        <i class="fa fa-calendar-check font-size-h3 text-info"></i>
                                    </div>
                                </div>
                                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                                    <a class="font-w500 d-flex align-items-center" href="{{ route('appointments.index') }}">
                                        View all appointments
                                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Today's Appointments -->
                        </div>
                        <div class="col-sm-6 col-xl-3">
                            <!-- Monthly Pharmacy Sales -->
                            <div class="block block-rounded d-flex flex-column">
                                <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between align-items-center">
                                    <dl class="mb-0">
                                        <dt class="font-size-h2 font-w700">₦{{ number_format($stats['total_revenue'], 2) }}</dt>
                                        <dd class="text-muted mb-0">Total Hospital Revenue</dd>
                                    </dl>
                                    <div class="item item-rounded bg-body">
                                        <i class="fa fa-pills font-size-h3 text-warning"></i>
                                    </div>
                                </div>
                                <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm">
                                    <a class="font-w500 d-flex align-items-center" href="{{ route('pharmacy-sales.index') }}">
                                        View pharmacy sales
                                        <i class="fa fa-arrow-alt-circle-right ml-1 opacity-25 font-size-base"></i>
                                    </a>
                                </div>
                            </div>
                            <!-- END Monthly Pharmacy Sales -->
                        </div>
                    </div>
                    <!-- END Overview -->

                    <!-- Statistics -->
                    <div class="row">
                        <div class="col-xl-8 d-flex flex-column">
                            <!-- Hospital Statistics -->
                            <div class="block block-rounded flex-grow-1 d-flex flex-column">
                                <div class="block-header block-header-default">
                                    <h3 class="block-title">Annual Revenue Overview</h3>
                                    <div class="block-options">
                                        <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                                            <i class="si si-refresh"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="block-content block-content-full flex-grow-1 d-flex align-items-center">
                                    <!-- Earnings Chart Container -->
                                    <canvas id="hospital-revenue-chart" style="height: 300px;"></canvas>
                                </div>
                                <div class="block-content bg-body-light">
                                    <div class="row items-push text-center w-100">
                                        <div class="col-sm-4">
                                            <dl class="mb-0">
                                                <dt class="font-size-h3 font-w700">
                                                    {{ $stats['total_patients'] }}
                                                </dt>
                                                <dd class="text-muted mb-0">Total Patients</dd>
                                            </dl>
                                        </div>
                                        <div class="col-sm-4">
                                            <dl class="mb-0">
                                                <dt class="font-size-h3 font-w700">
                                                    {{ $stats['admitted_patients'] }}
                                                </dt>
                                                <dd class="text-muted mb-0">Admitted Patients</dd>
                                            </dl>
                                        </div>
                                        <div class="col-sm-4">
                                            <dl class="mb-0">
                                                <dt class="font-size-h3 font-w700">
                                                    ₦{{ number_format($stats['monthly_sales'], 2) }}
                                                </dt>
                                                <dd class="text-muted mb-0">Revenue (This Month)</dd>
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Hospital Statistics -->
                        </div>
                        <div class="col-xl-4 d-flex flex-column">
                            <!-- Last 14 Days -->
                            <div class="row row-deck flex-grow-1">
                                <div class="col-md-6 col-xl-12">
                                    <div class="block block-rounded d-flex flex-column">
                                        <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between">
                                            <dl class="mb-0">
                                                <dt class="font-size-h2 font-w700">{{ $stats['todays_appointments'] }}</dt>
                                                <dd class="text-muted mb-0">Appointments (Today)</dd>
                                            </dl>
                                            <div>
                                                <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-info bg-info-light">
                                                    <i class="fa fa-calendar-check mr-1"></i>
                                                    Last 14 Days
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content p-1 text-center overflow-hidden">
                                            <!-- Sparkline Line: Appointments -->
                                            <span class="js-sparkline" data-type="line"
                                                  data-points="{{ $stats['sparkline_appointments'] }}"
                                                  data-width="100%"
                                                  data-height="70px"
                                                  data-chart-range-min="0"
                                                  data-line-color="rgba(70,195,123, .4)"
                                                  data-fill-color="rgba(70,195,123, .15)"
                                                  data-spot-color="transparent"
                                                  data-min-spot-color="transparent"
                                                  data-max-spot-color="transparent"
                                                  data-highlight-spot-color="#46C37B"
                                                  data-highlight-line-color="#46C37B"
                                                  data-tooltip-suffix=" Appointments"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 col-xl-12">
                                    <div class="block block-rounded d-flex flex-column">
                                        <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between">
                                            <dl class="mb-0">
                                                <dt class="font-size-h2 font-w700">₦{{ number_format($stats['monthly_sales'], 2) }}</dt>
                                                <dd class="text-muted mb-0">Revenue (Month)</dd>
                                            </dl>
                                            <div>
                                                <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-success bg-success-light">
                                                    <i class="fa fa-money-bill-wave mr-1"></i>
                                                    Last 14 Days
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content p-1 text-center oveflow-hidden">
                                            <!-- Sparkline Line: Revenue -->
                                            <span class="js-sparkline" data-type="line"
                                                  data-points="{{ $stats['sparkline_revenue'] }}"
                                                  data-width="100%"
                                                  data-height="70px"
                                                  data-chart-range-min="0"
                                                  data-line-color="rgba(70,195,123, .4)"
                                                  data-fill-color="rgba(70,195,123, .15)"
                                                  data-spot-color="transparent"
                                                  data-min-spot-color="transparent"
                                                  data-max-spot-color="transparent"
                                                  data-highlight-spot-color="#46C37B"
                                                  data-highlight-line-color="#46C37B"
                                                  data-tooltip-prefix="₦"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="block block-rounded d-flex flex-column">
                                        <div class="block-content block-content-full flex-grow-1 d-flex justify-content-between">
                                            <dl class="mb-0">
                                                <dt class="font-size-h2 font-w700">{{ $stats['total_patients'] }}</dt>
                                                <dd class="text-muted mb-0">Total Patients</dd>
                                            </dl>
                                            <div>
                                                <div class="d-inline-block px-2 py-1 rounded-lg font-size-sm font-w600 text-primary bg-primary-light">
                                                    <i class="fa fa-users mr-1"></i>
                                                    Last 14 Days
                                                </div>
                                            </div>
                                        </div>
                                        <div class="block-content p-1 text-center oveflow-hidden">
                                            <!-- Sparkline Line: New Patients -->
                                            <span class="js-sparkline" data-type="line"
                                                  data-points="{{ $stats['sparkline_patients'] }}"
                                                  data-width="100%"
                                                  data-height="70px"
                                                  data-chart-range-min="0"
                                                  data-line-color="rgba(70,195,123, .4)"
                                                  data-fill-color="rgba(70,195,123, .15)"
                                                  data-spot-color="transparent"
                                                  data-min-spot-color="transparent"
                                                  data-max-spot-color="transparent"
                                                  data-highlight-spot-color="#46C37B"
                                                  data-highlight-line-color="#46C37B"
                                                  data-tooltip-suffix=" Patients"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- END Last 14 Days -->
                        </div>
                    </div>
                    <!-- END Statistics -->

                    <!-- Recent Appointments -->
                    <div class="block block-rounded">
                        <div class="block-header block-header-default">
                            <h3 class="block-title">Recent Appointments</h3>
                            <div class="block-options">
                                <button type="button" class="btn btn-sm btn-alt-primary" data-toggle="class-toggle" data-target="#one-dashboard-search-orders" data-class="d-none">
                                    <i class="fa fa-search"></i>
                                </button>
                                <div class="dropdown d-inline-block">
                                    <button type="button" class="btn btn-sm btn-alt-primary" id="dropdown-recent-orders-filters" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fa fa-fw fa-flask"></i>
                                        Filters
                                        <i class="fa fa-angle-down ml-1"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-md dropdown-menu-right font-size-sm" aria-labelledby="dropdown-recent-orders-filters">
                                        <a class="dropdown-item font-w500 d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                            Pending..
                                            <span class="badge badge-primary badge-pill">35</span>
                                        </a>
                                        <a class="dropdown-item font-w500 d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                            Processing
                                            <span class="badge badge-primary badge-pill">15</span>
                                        </a>
                                        <a class="dropdown-item font-w500 d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                            For Delivery
                                            <span class="badge badge-primary badge-pill">20</span>
                                        </a>
                                        <a class="dropdown-item font-w500 d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                            Canceled
                                            <span class="badge badge-primary badge-pill">72</span>
                                        </a>
                                        <a class="dropdown-item font-w500 d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                            Delivered
                                            <span class="badge badge-primary badge-pill">890</span>
                                        </a>
                                        <a class="dropdown-item font-w500 d-flex align-items-center justify-content-between" href="javascript:void(0)">
                                            All
                                            <span class="badge badge-primary badge-pill">997</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="one-dashboard-search-orders" class="block-content border-bottom d-none">
                            <!-- Search Form -->
                            <form action="be_pages_dashboard.html" method="POST" onsubmit="return false;">
                                <div class="form-group push">
                                    <div class="input-group">
                                        <input type="text" class="form-control" id="one-ecom-orders-search" name="one-ecom-orders-search" placeholder="Search recent orders..">
                                        <div class="input-group-append">
                                            <span class="input-group-text">
                                                <i class="fa fa-search"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- END Search Form -->
                        </div>
                        <div class="block-content">
                            <!-- Recent Appointments Table -->
                            <div class="table-responsive">
                                <table class="table table-borderless table-striped table-vcenter">
                                    <thead>
                                        <tr>
                                            <th class="text-center" style="width: 120px;">ID</th>
                                            <th class="d-none d-sm-table-cell">Date</th>
                                            <th class="d-none d-xl-table-cell">Patient</th>
                                            <th>Doctor</th>
                                            <th class="d-none d-xl-table-cell">Status</th>
                                            <th class="d-none d-sm-table-cell">Time</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($stats['recent_appointments'] as $appointment)
                                        <tr>
                                            <td class="text-center font-size-sm">
                                                <a class="font-w600" href="{{ route('appointments.show', $appointment->id) }}">
                                                    <strong>#{{ $appointment->id }}</strong>
                                                </a>
                                            </td>
                                            <td class="d-none d-sm-table-cell font-size-sm font-w600 text-muted">
                                                {{ $appointment->appointment_date->format('M d, Y') }}
                                            </td>
                                            <td class="d-none d-xl-table-cell font-size-sm">
                                                <a class="font-w600" href="{{ route('patients.show', optional($appointment->patient)->id ?? '#') }}">
                                                    {{ optional($appointment->patient)->name ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td class="font-size-sm">
                                                {{ optional($appointment->doctor)->name ?? 'N/A' }}
                                            </td>
                                            <td class="d-none d-xl-table-cell">
                                                @if($appointment->status == 'scheduled')
                                                    <span class="font-size-sm font-w600 px-2 py-1 rounded bg-info-light text-info">Scheduled</span>
                                                @elseif($appointment->status == 'completed')
                                                    <span class="font-size-sm font-w600 px-2 py-1 rounded bg-success-light text-success">Completed</span>
                                                @elseif($appointment->status == 'cancelled')
                                                    <span class="font-size-sm font-w600 px-2 py-1 rounded bg-danger-light text-danger">Cancelled</span>
                                                @else
                                                    <span class="font-size-sm font-w600 px-2 py-1 rounded bg-warning-light text-warning">{{ ucfirst($appointment->status) }}</span>
                                                @endif
                                            </td>
                                            <td class="d-none d-sm-table-cell text-right font-size-sm">
                                                <strong>{{ optional($appointment->appointment_date)->format('h:i A') ?? 'N/A' }}</strong>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center text-muted py-4">
                                                No recent appointments found
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                            <!-- END Recent Appointments Table -->

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
                        </div>
                    </div>
                    <!-- END Recent Orders -->
                </div>
                <!-- END Page Content -->
@endsection

@push('scripts')
<script>
    jQuery(function(){
        // Init Chart.js for Hospital Revenue Overview
        var ctx = document.getElementById('hospital-revenue-chart');
        if (ctx) {
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [
                        {
                            label: 'Total Revenue',
                            fill: true,
                            backgroundColor: 'rgba(70, 195, 123, 0.10)',
                            borderColor: 'rgba(70, 195, 123, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(70, 195, 123, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            pointHoverBackgroundColor: '#fff',
                            pointHoverBorderColor: 'rgba(70, 195, 123, 1)',
                            data: {!! $stats['chart_earnings'] !!}
                        },
                        {
                            label: 'Pharmacy Sales',
                            fill: false,
                            backgroundColor: 'rgba(52, 144, 220, 0.10)',
                            borderColor: 'rgba(52, 144, 220, 1)',
                            borderWidth: 2,
                            borderDash: [],
                            pointBackgroundColor: 'rgba(52, 144, 220, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            data: {!! $stats['chart_pharmacy'] !!}
                        },
                        {
                            label: 'Billing Revenue',
                            fill: false,
                            backgroundColor: 'rgba(149, 97, 226, 0.10)',
                            borderColor: 'rgba(149, 97, 226, 1)',
                            borderWidth: 2,
                            pointBackgroundColor: 'rgba(149, 97, 226, 1)',
                            pointBorderColor: '#fff',
                            pointRadius: 4,
                            pointHoverRadius: 6,
                            data: {!! $stats['chart_billing'] !!}
                        }
                    ]
                },
                options: {
                    maintainAspectRatio: false,
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            boxWidth: 12,
                            padding: 16,
                            fontColor: '#6c757d',
                            fontSize: 12
                        }
                    },
                    scales: {
                        xAxes: [{
                            gridLines: {
                                color: 'rgba(0,0,0,0.04)'
                            },
                            ticks: {
                                fontColor: '#6c757d',
                                fontSize: 11
                            }
                        }],
                        yAxes: [{
                            gridLines: {
                                color: 'rgba(0,0,0,0.04)'
                            },
                            ticks: {
                                beginAtZero: true,
                                fontColor: '#6c757d',
                                fontSize: 11,
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return '₦' + (value / 1000000).toFixed(1) + 'M';
                                    } else if (value >= 1000) {
                                        return '₦' + (value / 1000).toFixed(0) + 'k';
                                    }
                                    return '₦' + value;
                                }
                            }
                        }]
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                        backgroundColor: 'rgba(255,255,255,0.95)',
                        titleFontColor: '#333',
                        bodyFontColor: '#555',
                        borderColor: '#e0e0e0',
                        borderWidth: 1,
                        callbacks: {
                            label: function(tooltipItem, data) {
                                var label = data.datasets[tooltipItem.datasetIndex].label || '';
                                var val = tooltipItem.yLabel;
                                var formatted = '₦' + parseFloat(val).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
                                return ' ' + label + ': ' + formatted;
                            }
                        }
                    },
                    elements: {
                        line: {
                            tension: 0.35
                        }
                    }
                }
            });
        }
    });
</script>
@endpush
