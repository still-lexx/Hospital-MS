@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">{{ isset($labTest) ? 'Edit' : 'Add' }} Lab Test</h1>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ isset($labTest) ? route('lab-tests.update', $labTest) : route('lab-tests.store') }}" method="POST">
                @csrf
                @if(isset($labTest))
                    @method('PUT')
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Test Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="name" value="{{ old('name', $labTest->name ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Category</label>
                            <input type="text" class="form-control" name="category" value="{{ old('category', $labTest->category ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Price (₦) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" name="price" value="{{ old('price', $labTest->price ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Normal Range</label>
                            <input type="text" class="form-control" name="normal_range" value="{{ old('normal_range', $labTest->normal_range ?? '') }}">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Unit</label>
                            <input type="text" class="form-control" name="unit" value="{{ old('unit', $labTest->unit ?? '') }}">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description" rows="3">{{ old('description', $labTest->description ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select class="form-control" name="status" required>
                        <option value="active" {{ old('status', $labTest->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $labTest->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ isset($labTest) ? 'Update' : 'Create' }}</button>
                    <a href="{{ route('lab-tests.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
