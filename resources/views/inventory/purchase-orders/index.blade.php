@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Purchase Orders
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a class="link-fx" href="">Purchase Orders</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">Order List</h3>
            <div class="block-options">
                <a href="{{ route('purchase-orders.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus mr-1"></i> Create Order
                </a>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Supplier</th>
                            <th>Date</th>
                            <th>Expected Delivery</th>
                            <th>Status</th>
                            <th>Total</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($purchaseOrders as $po)
                            <tr>
                                <td class="font-w600">
                                    <a href="{{ route('purchase-orders.show', $po) }}">{{ $po->order_number }}</a>
                                </td>
                                <td>
                                    @if($po->supplier)
                                        <a href="{{ route('suppliers.show', $po->supplier) }}">{{ $po->supplier->name }}</a>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $po->order_date->format('Y-m-d') }}</td>
                                <td>{{ $po->expected_delivery ? $po->expected_delivery->format('Y-m-d') : '-' }}</td>
                                <td>
                                    @if($po->status === 'received')
                                        <span class="badge badge-success">Received</span>
                                    @elseif($po->status === 'pending')
                                        <span class="badge badge-warning">Pending</span>
                                    @else
                                        <span class="badge badge-secondary">Cancelled</span>
                                    @endif
                                </td>
                                <td>₦{{ number_format($po->total_amount, 2) }}</td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('purchase-orders.show', $po) }}" class="btn btn-sm btn-alt-secondary" data-toggle="tooltip" title="View">
                                            <i class="fa fa-eye"></i>
                                        </a>
                                        @if($po->status === 'pending')
                                            <a href="{{ route('purchase-orders.edit', $po) }}" class="btn btn-sm btn-alt-secondary" data-toggle="tooltip" title="Edit">
                                                <i class="fa fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('purchase-orders.destroy', $po) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-alt-danger" data-toggle="tooltip" title="Delete">
                                                    <i class="fa fa-times"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <p class="mb-0 py-4">No purchase orders found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="py-2">
                {{ $purchaseOrders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
