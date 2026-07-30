@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Surgery Reports</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('surgery-reports.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Report
                </a>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th>Report Date</th>
                        <th>Patient</th>
                        <th>Surgery</th>
                        <th>Reported By</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                    <tr>
                        <td>{{ $report->report_date->format('M d, Y') }}</td>
                        <td>{{ $report->surgery->patient->name }}</td>
                        <td>{{ $report->surgery->surgery_name }}</td>
                        <td>{{ $report->reporter->name }}</td>
                        <td class="text-center">
                            <a href="{{ route('surgery-reports.show', $report) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                            <a href="{{ route('surgery-reports.edit', $report) }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">No surgery reports found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $reports->links() }}
        </div>
    </div>
</div>
@endsection
