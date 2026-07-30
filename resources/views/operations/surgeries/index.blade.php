@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Surgery Schedule</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('surgeries.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Schedule Surgery
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
                        <th>Surgery</th>
                        <th>Doctor</th>
                        <th>OT Room</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($surgeries as $surgery)
                    <tr>
                        <td>{{ $surgery->surgery_date->format('M d, Y') }}</td>
                        <td>{{ $surgery->patient->name }}</td>
                        <td>{{ $surgery->surgery_name }}</td>
                        <td>{{ $surgery->doctor->name }}</td>
                        <td>{{ $surgery->otRoom->room_name ?? 'Not assigned' }}</td>
                        <td><span class="badge badge-{{ $surgery->type == 'emergency' ? 'danger' : 'info' }}">{{ ucfirst($surgery->type) }}</span></td>
                        <td><span class="badge badge-{{ $surgery->status == 'completed' ? 'success' : ($surgery->status == 'in-progress' ? 'warning' : 'secondary') }}">{{ ucfirst($surgery->status) }}</span></td>
                        <td class="text-center">
                            <a href="{{ route('surgeries.show', $surgery) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center">No surgeries scheduled.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $surgeries->links() }}
        </div>
    </div>
</div>
@endsection
