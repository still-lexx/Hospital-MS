@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Prescriptions</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('prescriptions.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Prescription
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
                        <th>Doctor</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($prescriptions as $prescription)
                    <tr>
                        <td>{{ $prescription->prescription_date->format('M d, Y') }}</td>
                        <td>{{ $prescription->patient->name }}</td>
                        <td>{{ $prescription->doctor->name ?? 'N/A' }}</td>
                        <td>{{ $prescription->items->count() }} items</td>
                        <td>
                            <span class="badge badge-{{ $prescription->status == 'active' ? 'success' : ($prescription->status == 'completed' ? 'info' : 'secondary') }}">
                                {{ ucfirst($prescription->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('prescriptions.show', $prescription) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No prescriptions found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $prescriptions->links() }}
        </div>
    </div>
</div>
@endsection
