@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Sale Details</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Sale Information</h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Patient:</strong> {{ optional($pharmacySale->patient)->name ?? 'N/A' }}</p>
                    <p><strong>Sale Date:</strong> {{ optional($pharmacySale->sale_date)->format('M d, Y') ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Payment Method:</strong> {{ ucfirst($pharmacySale->payment_method) }}</p>
                    <p><strong>Status:</strong> <span class="badge badge-success">{{ ucfirst($pharmacySale->status) }}</span></p>
                </div>
            </div>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Items Sold</h3>
        </div>
        <div class="block-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Medicine</th>
                        <th>Quantity</th>
                        <th>Unit Price</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pharmacySale->items as $item)
                    <tr>
                        <td>{{ optional($item->inventoryItem)->name ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>₦{{ number_format($item->unit_price, 2) }}</td>
                        <td>₦{{ number_format($item->total, 2) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                        <td><strong>₦{{ number_format($pharmacySale->total_amount, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
