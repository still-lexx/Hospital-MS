@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Lab Test Requests</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('lab-test-requests.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Request
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
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Test</th>
                        <th>Doctor</th>
                        <th>Priority</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $request)
                    <tr>
                        <td>{{ $request->request_date->format('M d, Y') }}</td>
                        <td>{{ $request->patient->name }}</td>
                        <td>{{ $request->labTest->name }}</td>
                        <td>{{ $request->doctor->name ?? '-' }}</td>
                        <td>
                            <span class="badge badge-{{ $request->priority == 'stat' ? 'danger' : ($request->priority == 'urgent' ? 'warning' : 'info') }}">
                                {{ strtoupper($request->priority) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge badge-{{ $request->status == 'completed' ? 'success' : ($request->status == 'in-progress' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($request->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('lab-test-requests.show', $request) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No requests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $requests->links() }}
        </div>
    </div>
</div>
@endsection
