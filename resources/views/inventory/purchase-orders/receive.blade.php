@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Receive Order: {{ $purchaseOrder->order_number }}
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('purchase-orders.index') }}">Purchase Orders</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Receive
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <form action="{{ route('purchase-orders.storeReceive', $purchaseOrder) }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">Receive Items</h3>
                        <div class="block-options">
                            <div class="form-group mb-0">
                                <label for="received_date" class="sr-only">Received Date</label>
                                <input type="date" class="form-control form-control-sm" id="received_date" name="received_date" value="{{ date('Y-m-d') }}" required>
                            </div>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-vcenter">
                                <thead>
                                    <tr>
                                        <th style="width: 25%;">Item</th>
                                        <th style="width: 10%;">Ordered</th>
                                        <th style="width: 15%;">Received Qty</th>
                                        <th style="width: 15%;">Batch Number</th>
                                        <th style="width: 15%;">Expiry Date</th>
                                        <th style="width: 20%;">Location</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($purchaseOrder->items as $index => $item)
                                    <tr>
                                        <td>
                                            <input type="hidden" name="items[{{ $index }}][id]" value="{{ $item->id }}">
                                            <span class="font-w600">{{ $item->inventoryItem->name }}</span>
                                            <br>
                                            <small class="text-muted">SKU: {{ $item->inventoryItem->sku }}</small>
                                        </td>
                                        <td class="text-center">
                                            <span class="badge badge-primary">{{ $item->quantity }}</span>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control" name="items[{{ $index }}][received_quantity]" value="{{ $item->quantity }}" min="0" max="{{ $item->quantity }}" required>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="items[{{ $index }}][batch_number]" placeholder="Batch #">
                                        </td>
                                        <td>
                                            <input type="date" class="form-control" name="items[{{ $index }}][expiry_date]">
                                        </td>
                                        <td>
                                            <input type="text" class="form-control" name="items[{{ $index }}][location]" placeholder="e.g. Shelf A1">
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right bg-body-light">
                        <a href="{{ route('purchase-orders.show', $purchaseOrder) }}" class="btn btn-alt-secondary">Cancel</a>
                        <button type="submit" class="btn btn-success">
                            <i class="fa fa-check mr-1"></i> Process Receipt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
