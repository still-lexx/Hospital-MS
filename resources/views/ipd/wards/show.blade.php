@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Manage Beds: {{ $ward->name }} <small class="text-muted font-size-base">(Capacity: {{ $ward->capacity }})</small></h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-add-bed">
                    <i class="fa fa-plus"></i> Add Bed
                </button>
                <a href="{{ route('wards.index') }}" class="btn btn-secondary">Back</a>
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
                        <th>Bed Number</th>
                        <th>Daily Charge</th>
                        <th>Status</th>
                        <th>Current Patient</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ward->beds as $bed)
                    <tr>
                        <td class="font-w600">{{ $bed->bed_number }}</td>
                        <td>₦{{ number_format($bed->daily_charge, 2) }}</td>
                        <td>
                            <span class="badge badge-{{ $bed->status == 'available' ? 'success' : ($bed->status == 'occupied' ? 'danger' : 'warning') }}">
                                {{ ucfirst($bed->status) }}
                            </span>
                        </td>
                        <td>
                            @if($bed->status == 'occupied' && $bed->currentAdmission)
                                {{ $bed->currentAdmission->patient->name }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">No beds added to this ward yet.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Bed Modal -->
<div class="modal fade" id="modal-add-bed" tabindex="-1" role="dialog" aria-labelledby="modal-add-bed" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('wards.add-bed', $ward) }}" method="POST">
                @csrf
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Add New Bed</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content font-size-sm">
                        <div class="form-group">
                            <label>Bed Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="bed_number" required placeholder="e.g., B-101">
                        </div>
                        <div class="form-group">
                            <label>Daily Charge (₦) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="daily_charge" required>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Add Bed</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
