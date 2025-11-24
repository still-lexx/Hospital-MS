@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Stock Management
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a class="link-fx" href="">Stock</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">Current Stock Levels</h3>
            <div class="block-options">
                <a href="{{ route('stock.movements') }}" class="btn btn-sm btn-alt-primary">
                    <i class="fa fa-history mr-1"></i> View Movements
                </a>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Item Name</th>
                            <th>Category</th>
                            <th>SKU</th>
                            <th class="text-center">Quantity</th>
                            <th>Unit</th>
                            <th>Status</th>
                            <th class="text-center" style="width: 100px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($items as $item)
                            <tr>
                                <td class="font-w600">
                                    <a href="{{ route('items.show', $item) }}">{{ $item->name }}</a>
                                    @if($item->is_low_stock)
                                        <span class="badge badge-danger ml-1">Low Stock</span>
                                    @endif
                                </td>
                                <td>
                                    @if($item->category)
                                        {{ $item->category->name }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $item->sku ?? '-' }}</td>
                                <td class="text-center">
                                    <span class="badge {{ $item->is_low_stock ? 'badge-danger' : 'badge-success' }} font-size-base">
                                        {{ $item->total_quantity }}
                                    </span>
                                </td>
                                <td>{{ $item->unit }}</td>
                                <td>
                                    @if($item->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Inactive</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="btn-group">
                                        <a href="{{ route('stock.adjust', $item) }}" class="btn btn-sm btn-alt-primary" data-toggle="tooltip" title="Adjust Stock">
                                            <i class="fa fa-sliders-h"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <p class="mb-0 py-4">No inventory items found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
