@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Category: {{ $category->name }}
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('categories.index') }}">Categories</a>
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
                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-alt-primary">
                            <i class="fa fa-pencil-alt"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="block-content">
                    <table class="table table-borderless table-striped">
                        <tbody>
                            <tr>
                                <td class="font-w600" style="width: 30%;">Type</td>
                                <td>
                                    @if($category->type === 'medicine')
                                        <span class="badge badge-primary">Medicine</span>
                                    @elseif($category->type === 'equipment')
                                        <span class="badge badge-info">Equipment</span>
                                    @else
                                        <span class="badge badge-secondary">Supplies</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td class="font-w600">Items</td>
                                <td>{{ $category->inventoryItems->count() }}</td>
                            </tr>
                            <tr>
                                <td class="font-w600">Description</td>
                                <td>{{ $category->description ?? '-' }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="block block-rounded">
                <div class="block-header">
                    <h3 class="block-title">Items in Category</h3>
                </div>
                <div class="block-content">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Item Name</th>
                                    <th>SKU</th>
                                    <th>Stock</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($category->inventoryItems as $item)
                                    <tr>
                                        <td class="font-w600">
                                            <a href="{{ route('items.show', $item) }}">{{ $item->name }}</a>
                                        </td>
                                        <td>{{ $item->sku ?? '-' }}</td>
                                        <td>{{ $item->total_quantity }} {{ $item->unit }}</td>
                                        <td>
                                            @if($item->status === 'active')
                                                <span class="badge badge-success">Active</span>
                                            @else
                                                <span class="badge badge-warning">Inactive</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('items.show', $item) }}" class="btn btn-sm btn-alt-secondary">
                                                <i class="fa fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">
                                            <p class="mb-0 py-2">No items found in this category.</p>
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
