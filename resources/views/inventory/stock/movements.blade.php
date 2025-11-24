@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Stock Movements
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('stock.index') }}">Stock</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Movements
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">Filter Movements</h3>
        </div>
        <div class="block-content">
            <form action="{{ route('stock.movements') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="item_id">Item</label>
                            <select class="form-control" id="item_id" name="item_id">
                                <option value="">All Items</option>
                                @foreach($items as $item)
                                    <option value="{{ $item->id }}" {{ request('item_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select class="form-control" id="type" name="type">
                                <option value="">All Types</option>
                                <option value="in" {{ request('type') == 'in' ? 'selected' : '' }}>In (+)</option>
                                <option value="out" {{ request('type') == 'out' ? 'selected' : '' }}>Out (-)</option>
                                <option value="adjustment" {{ request('type') == 'adjustment' ? 'selected' : '' }}>Adjustment</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_from">Date From</label>
                            <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="date_to">Date To</label>
                            <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group" style="padding-top: 30px;">
                            <button type="submit" class="btn btn-primary btn-block">Filter</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">Movement History</h3>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Item</th>
                            <th>Type</th>
                            <th>Quantity</th>
                            <th>Reference</th>
                            <th>User</th>
                            <th>Notes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($movements as $movement)
                            <tr>
                                <td>{{ $movement->created_at->format('Y-m-d H:i') }}</td>
                                <td class="font-w600">{{ $movement->inventoryItem->name }}</td>
                                <td>
                                    @if($movement->type === 'in')
                                        <span class="badge badge-success">In (+)</span>
                                    @elseif($movement->type === 'out')
                                        <span class="badge badge-danger">Out (-)</span>
                                    @else
                                        <span class="badge badge-info">Adjustment</span>
                                    @endif
                                </td>
                                <td class="font-w600">{{ $movement->quantity }}</td>
                                <td>
                                    @if($movement->reference_type)
                                        <span class="badge badge-light">{{ $movement->reference_type }}</span>
                                        @if($movement->reference_id)
                                            <small class="text-muted">#{{ $movement->reference_id }}</small>
                                        @endif
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $movement->user->name ?? 'System' }}</td>
                                <td>{{ $movement->notes }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">
                                    <p class="mb-0 py-4">No stock movements found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="py-2">
                {{ $movements->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
