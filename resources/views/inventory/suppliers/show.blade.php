@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Supplier: {{ $supplier->name }}
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('suppliers.index') }}">Suppliers</a>
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
                    <h3 class="block-title">Contact Info</h3>
                    <div class="block-options">
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-pencil-alt"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="block-content">
                    <table class="table table-borderless table-striped">
                        <tbody>
                            <tr>
                                <td class="font-w600" style="width: 30%;">Contact</td>
                                <td>{{ $supplier->contact_person ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Email</td>
                                <td>{{ $supplier->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Phone</td>
                                <td>{{ $supplier->phone }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Address</td>
                                <td>{{ $supplier->address ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Status</td>
                                <td>
                                    @if($supplier->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">Purchase Orders</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Total</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($supplier->purchaseOrders as $po)
                                    <tr>
                                        <td class="font-w600">
                                            <a href="{{ route('purchase-orders.show', $po) }}">{{ $po->order_number }}</a>
                                        </td>
                                        <td>{{ $po->order_date->format('Y-m-d') }}</td>
                                        <td>
                                            @if($po->status === 'received')
                                                <span class="badge badge-success">Received</span>
                                            @elseif($po->status === 'pending')
                                                <span class="badge badge-warning">Pending</span>
                                            @else
                                                <span class="badge badge-secondary">Cancelled</span>
                                            @endif
                                        </td>
                                        <td>${{ number_format($po->total_amount, 2) }}</td>
                                        <td>
                                            <a href="{{ route('purchase-orders.show', $po) }}" class="btn btn-sm btn-alt-secondary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <p class="mb-0 py-2">No purchase orders found.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
