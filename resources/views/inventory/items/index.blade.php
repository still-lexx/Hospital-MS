@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Inventory Items
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item" aria-current="page">
                        <a class="link-fx" href="">Items</a>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header">
            <h3 class="block-title">Item List</h3>
            <div class="block-options">
                <a href="{{ route('items.create') }}" class="btn btn-sm btn-primary">
                    <i class="fa fa-plus mr-1"></i> Add Item
                </a>
            </div>
        </div>
        <div class="block-content">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Category</th>
                            <th>SKU</th>
                            <th class="text-center">Stock</th>
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
                                        <a href="{{ route('categories.show', $item->category) }}">{{ $item->category->name }}</a>
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
                                        <a href="{{ route('items.edit', $item) }}" class="btn btn-sm btn-alt-secondary" data-toggle="tooltip" title="Edit">
                                            <i class="fa fa-fw fa-pencil-alt"></i>
                                        </a>
                                        <a href="{{ route('stock.adjust', $item) }}" class="btn btn-sm btn-alt-primary" data-toggle="tooltip" title="Adjust Stock">
                                            <i class="fa fa-sliders-h"></i>
                                        </a>
                                        <form action="{{ route('items.destroy', $item) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this item?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-alt-danger" data-toggle="tooltip" title="Delete">
                                                <i class="fa fa-fw fa-times"></i>
                                            </button>
                                        </form>
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
            <div class="py-2">
                {{ $items->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
