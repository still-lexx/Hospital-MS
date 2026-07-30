@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Admitted Patients</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('ipd-admissions.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Admission
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
                        <th>Admission Date</th>
                        <th>Patient</th>
                        <th>Doctor</th>
                        <th>Ward / Bed</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($admissions as $admission)
                    <tr>
                        <td>{{ $admission->admission_date->format('M d, Y H:i') }}</td>
                        <td>{{ $admission->patient->name }}</td>
                        <td>{{ $admission->doctor->name }}</td>
                        <td>
                            {{ $admission->bed->ward->name }}<br>
                            <small class="text-muted">Bed: {{ $admission->bed->bed_number }}</small>
                        </td>
                        <td>
                            <span class="badge badge-success">{{ ucfirst($admission->status) }}</span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('ipd-admissions.show', $admission) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i> View
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No currently admitted patients.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $admissions->links() }}
        </div>
    </div>
</div>
@endsection
