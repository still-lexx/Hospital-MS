@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">OPD Medical Records</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <form action="{{ route('opd-records.index') }}" method="GET" class="d-inline-block">
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control form-control-alt" placeholder="Search Patient..." name="search" value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-alt-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
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
                        <th>Date</th>
                        <th>Token</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Diagnosis</th>
                        <th class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($records as $record)
                    <tr>
                        <td>{{ $record->visit_date->format('M d, Y') }}</td>
                        <td><span class="badge badge-secondary">{{ $record->token_number }}</span></td>
                        <td>{{ $record->patient->name }}</td>
                        <td>{{ $record->doctor->name }}</td>
                        <td>{{ Str::limit($record->consultation->diagnosis ?? 'N/A', 50) }}</td>
                        <td class="text-center">
                            <a href="{{ route('opd-records.show', $record) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-file-medical"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No medical records found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $records->links() }}
        </div>
    </div>
</div>
@endsection
