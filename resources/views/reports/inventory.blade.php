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

    <!-- Placeholder Notice -->
    <div class="block block-rounded">
        <div class="block-content">
            <div class="alert alert-info d-flex align-items-center" role="alert">
                <div class="flex-shrink-0">
                    <i class="fa fa-fw fa-info-circle"></i>
                </div>
                <div class="flex-grow-1 ml-3">
                    <p class="mb-0">
                        <strong>Inventory Module Not Yet Implemented</strong><br>
                        This report will display stock levels, usage patterns, and expiring items once the inventory management module is implemented.
                        The system will track medicines, medical supplies, equipment, and other hospital inventory.
                    </p>
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
                    <div class="text-center py-5">
                        <i class="fa fa-chart-pie fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No data available</p>
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
                    <div class="text-center py-5">
                        <i class="fa fa-chart-line fa-3x text-muted mb-3"></i>
                        <p class="text-muted">No data available</p>
                    </div>
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
                                <tr>
                                    <td colspan="3" class="text-center">No items to display</td>
                                </tr>
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
                                <tr>
                                    <td colspan="3" class="text-center">No items to display</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
