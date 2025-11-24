@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Order: {{ $purchaseOrder->order_number }}
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('purchase-orders.index') }}">Purchase Orders</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Details
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-4">
            <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">Order Info</h3>
                    <div class="block-options">
                        @if($purchaseOrder->status === 'pending')
                            <a href="{{ route('purchase-orders.edit', $purchaseOrder) }}" class="btn btn-sm btn-alt-primary">
                                <i class="fa fa-pencil-alt"></i> Edit
                            </a>
                            <a href="{{ route('purchase-orders.receive', $purchaseOrder) }}" class="btn btn-sm btn-success">
                                <i class="fa fa-check"></i> Receive
                            </a>
                        @endif
                    </div>
                </div>
                <div class="block-content">
                    <table class="table table-borderless table-striped">
                        <tbody>
                            <tr>
                                <td class="font-w600" style="width: 40%;">Supplier</td>
                                <td>
                                    @if($purchaseOrder->supplier)
                                        <a href="{{ route('suppliers.show', $purchaseOrder->supplier) }}">{{ $purchaseOrder->supplier->name }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="font-w600">Order Date</td>
                                <td>{{ $purchaseOrder->order_date->format('Y-m-d') }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Expected</td>
                                <td>{{ $purchaseOrder->expected_delivery ? $purchaseOrder->expected_delivery->format('Y-m-d') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Received</td>
                                <td>{{ $purchaseOrder->received_date ? $purchaseOrder->received_date->format('Y-m-d') : '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Status</td>
                                <td>
                                    @if($purchaseOrder->status === 'received')
                                        <span class="badge badge-success">Received</span>
                                    @elseif($purchaseOrder->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-secondary">Cancelled</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="font-w600">Total Amount</td>
                                <td class="font-w700">${{ number_format($purchaseOrder->total_amount, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Notes</td>
                                <td>{{ $purchaseOrder->notes ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">Order Items</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>SKU</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Unit Price</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($purchaseOrder->items as $item)
                                    <tr>
                                        <td class="font-w600">
                                            @if($item->inventoryItem)
                                                <a href="{{ route('items.show', $item->inventoryItem) }}">{{ $item->inventoryItem->name }}</a>
                                            @else
                                                Unknown Item
                                            @endif
                                        </td>
                                        <td>{{ $item->inventoryItem->sku ?? '-' }}</td>
                                        <td class="text-center">{{ $item->quantity }}</td>
                                        <td class="text-right">${{ number_format($item->unit_price, 2) }}</td>
                                        <td class="text-right">${{ number_format($item->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="4" class="text-right font-w700">Grand Total:</td>
                                    <td class="text-right font-w700">${{ number_format($purchaseOrder->total_amount, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
