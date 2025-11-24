@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Adjust Stock: {{ $item->name }}
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('stock.index') }}">Stock</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Adjust
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">Stock Adjustment Form</h3>
                </div>
                <div class="block-content">
                    <div class="row mb-4">
                        <div class="col-6">
                            <div class="alert alert-info mb-0">
                                <p class="mb-0"><strong>Current Stock:</strong> {{ $currentStock }} {{ $item->unit }}</p>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="alert alert-secondary mb-0">
                                <p class="mb-0"><strong>SKU:</strong> {{ $item->sku ?? 'N/A' }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('stock.storeAdjustment', $item) }}" method="POST">
                        @csrf
                        
                        <div class="form-group">
                            <label>Adjustment Type <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio custom-control-primary mb-1">
                                        <input type="radio" class="custom-control-input" id="type_add" name="adjustment_type" value="add" checked>
                                        <label class="custom-control-label" for="type_add">Add Stock (+)</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio custom-control-danger mb-1">
                                        <input type="radio" class="custom-control-input" id="type_subtract" name="adjustment_type" value="subtract">
                                        <label class="custom-control-label" for="type_subtract">Remove Stock (-)</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="custom-control custom-radio custom-control-info mb-1">
                                        <input type="radio" class="custom-control-input" id="type_set" name="adjustment_type" value="set">
                                        <label class="custom-control-label" for="type_set">Set Quantity (=)</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="quantity">Quantity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" id="quantity" name="quantity" min="1" required>
                            <small class="form-text text-muted">Enter the quantity to add, remove, or set.</small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="batch_number">Batch Number</label>
                                    <input type="text" class="form-control" id="batch_number" name="batch_number">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="expiry_date">Expiry Date</label>
                                    <input type="date" class="form-control" id="expiry_date" name="expiry_date">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="location">Location</label>
                            <input type="text" class="form-control" id="location" name="location" placeholder="e.g. Warehouse A, Shelf 3">
                        </div>

                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Reason for adjustment..."></textarea>
                        </div>

                        <div class="form-group text-right">
                            <a href="{{ route('stock.index') }}" class="btn btn-alt-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Save Adjustment</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
