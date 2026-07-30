@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Inventory Reports <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Stock and supplies management</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item">Reports</li>
                    <li class="breadcrumb-item active" aria-current="page">Inventory</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <!-- Inventory Overview -->
    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-primary-light text-primary mx-auto">
                        <i class="fa fa-boxes"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Total Items</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($totalItems) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-warning-light text-warning mx-auto">
                        <i class="fa fa-exclamation-triangle"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Low Stock</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($lowStockItems) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-danger-light text-danger mx-auto">
                        <i class="fa fa-times-circle"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Out of Stock</p>
                    <p class="font-size-h2 font-w700 mb-0">{{ number_format($outOfStockItems) }}</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="block block-rounded text-center">
                <div class="block-content block-content-full">
                    <div class="item item-circle bg-success-light text-success mx-auto">
                        <i class="fa fa-dollar-sign"></i>
                    </div>
                </div>
                <div class="block-content py-2 bg-body-light">
                    <p class="font-w600 font-size-sm text-muted mb-0">Inventory Value</p>
                    <p class="font-size-h2 font-w700 mb-0">₦{{ number_format($inventoryValue) }}</p>
                </div>
            </div>
        </div>
    </div>


    <!-- Placeholder Charts -->
    <div class="row">
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Stock by Category</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-vcenter">
                            <tbody>
                                @foreach($stockByCategory as $category)
                                <tr>
                                    <td>{{ $category->name }}</td>
                                    <td class="text-right">
                                        <span class="badge badge-primary">{{ $category->inventory_items_count }} Items</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-3">
                        {{ $stockByCategory->appends(request()->except('category_page'))->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Stock Movement Trend</h3>
                </div>
                <div class="block-content">
                    <ul class="list list-activity">
                        @forelse($recentActivity as $activity)
                        <li>
                            <i class="fa fa-{{ $activity->type == 'in' ? 'arrow-down text-success' : 'arrow-up text-danger' }} list-activity-icon"></i>
                            <div class="font-w600">{{ $activity->inventoryItem->name }}</div>
                            <div class="font-size-sm">{{ ucfirst($activity->type) }}: {{ $activity->quantity }} units</div>
                            <div class="font-size-xs text-muted">{{ $activity->created_at->diffForHumans() }} by {{ $activity->user->name }}</div>
                        </li>
                        @empty
                        <li class="text-center text-muted">No recent activity</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Placeholder Tables -->
    <div class="row">
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Low Stock Items</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Current Stock</th>
                                    <th>Min. Required</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lowStockList as $stock)
                                <tr>
                                    <td class="font-w600">{{ $stock->inventoryItem->name }}</td>
                                    <td>
                                        <span class="text-danger font-w700">{{ $stock->quantity }}</span>
                                    </td>
                                    <td>{{ $stock->inventoryItem->reorder_level }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No items currently low on stock</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Expiring Soon</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>Batch No.</th>
                                    <th>Expiry Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($expiringItems as $stock)
                                <tr>
                                    <td class="font-w600">{{ $stock->inventoryItem->name }}</td>
                                    <td>{{ $stock->batch_number }}</td>
                                    <td>
                                        <span class="badge badge-{{ $stock->expiry_date && $stock->expiry_date->isPast() ? 'danger' : 'warning' }}">
                                            {{ $stock->expiry_date ? $stock->expiry_date->format('M d, Y') : 'N/A' }}
                                        </span>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">No items expiring soon</td>
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
