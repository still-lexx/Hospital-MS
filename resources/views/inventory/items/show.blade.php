@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Item: {{ $item->name }}
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('items.index') }}">Items</a>
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
                    <h3 class="block-title">Info</h3>
                    <div class="block-options">
                        <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-pencil-alt"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="block-content">
                    <table class="table table-borderless table-striped">
                        <tbody>
                            <tr>
                                <td class="font-w600" style="width: 30%;">Category</td>
                                <td>
                                    @if($item->category)
                                        <a href="{{ route('categories.show', $item->category) }}">{{ $item->category->name }}</a>
                                    @else
                                        N/A
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="font-w600">SKU</td>
                                <td>{{ $item->sku ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Unit</td>
                                <td>{{ $item->unit }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Reorder Level</td>
                                <td>{{ $item->reorder_level }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Status</td>
                                <td>
                                    @if($item->status === 'active')
                                        <span class="badge badge-success">Active</span>
                                    @else
                                        <span class="badge badge-warning">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="font-w600">Description</td>
                                <td>{{ $item->description ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">Stock Status</h3>
                    <div class="block-options">
                        <a href="{{ route('stock.adjust', $item) }}" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-sliders-h"></i> Adjust
                        </a>
                    </div>
                </div>
                <div class="block-content block-content-full text-center">
                    <div class="font-size-h2 font-w700 {{ $item->is_low_stock ? 'text-danger' : 'text-success' }}">
                        {{ $totalQuantity }}
                    </div>
                    <div class="text-muted mb-3">{{ $item->unit }} in stock</div>
                    
                    @if($item->is_low_stock)
                        <div class="alert alert-danger mb-0">
                            <i class="fa fa-exclamation-triangle mr-1"></i> Low Stock Alert
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">Recent Movements</h3>
                    <div class="block-options">
                        <a href="{{ route('stock.movements', ['item_id' => $item->id]) }}" class="btn btn-sm btn-alt-secondary">
                            View All
                        </a>
                    </div>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Quantity</th>
                                    <th>Reference</th>
                                    <th>User</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentMovements as $movement)
                                    <tr>
                                        <td>{{ $movement->created_at->format('Y-m-d H:i') }}</td>
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
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $movement->user->name ?? 'System' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <p class="mb-0 py-2">No recent movements.</p>
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
