@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Pharmacy Sales</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('pharmacy-sales.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Sale
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
                        <th>Total Amount</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($sales as $sale)
                    <tr>
                        <td>{{ $sale->sale_date->format('M d, Y') }}</td>
                        <td>{{ $sale->patient->name }}</td>
                        <td>₦{{ number_format($sale->total_amount, 2) }}</td>
                        <td>{{ ucfirst($sale->payment_method) }}</td>
                        <td>
                            <span class="badge badge-{{ $sale->status == 'completed' ? 'success' : ($sale->status == 'pending' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($sale->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('pharmacy-sales.show', $sale) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No sales found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $sales->links() }}
        </div>
    </div>
</div>
@endsection
