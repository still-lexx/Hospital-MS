@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Create New Ward</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('wards.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label>Ward Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" required placeholder="e.g., General Ward A">
                </div>

                <div class="form-group">
                    <label>Ward Type <span class="text-danger">*</span></label>
                    <select class="form-control" name="type" required>
                        <option value="General">General</option>
                        <option value="Private">Private</option>
                        <option value="ICU">ICU</option>
                        <option value="Emergency">Emergency</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Capacity (Number of Beds) <span class="text-danger">*</span></label>
                    <input type="number" class="form-control" name="capacity" required min="1">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea class="form-control" name="description" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Ward</button>
                    <a href="{{ route('wards.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
