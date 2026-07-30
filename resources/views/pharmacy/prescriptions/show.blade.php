@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Prescription Details</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Prescription Information</h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Patient:</strong> {{ $prescription->patient->name }}</p>
                    <p><strong>Doctor:</strong> {{ $prescription->doctor->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Date:</strong> {{ $prescription->prescription_date->format('M d, Y') }}</p>
                    <p><strong>Status:</strong> <span class="badge badge-{{ $prescription->status == 'active' ? 'success' : 'info' }}">{{ ucfirst($prescription->status) }}</span></p>
                </div>
            </div>
            @if($prescription->notes)
            <p><strong>Notes:</strong> {{ $prescription->notes }}</p>
            @endif
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Prescribed Medicines</h3>
        </div>
        <div class="block-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Dosage</th>
                        <th>Frequency</th>
                        <th>Duration</th>
                        <th>Quantity</th>
                        <th>Instructions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($prescription->items as $item)
                    <tr>
                        <td>{{ $item->medicine_name }}</td>
                        <td>{{ $item->dosage }}</td>
                        <td>{{ $item->frequency }}</td>
                        <td>{{ $item->duration }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->instructions ?? '-' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
