@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Ward Management</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('wards.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Ward
                </a>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="row">
        @forelse($wards as $ward)
        <div class="col-md-6 col-xl-4">
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">{{ $ward->name }}</h3>
                    <div class="block-options">
                        <span class="badge badge-{{ $ward->type == 'ICU' ? 'danger' : ($ward->type == 'Private' ? 'warning' : 'primary') }}">
                            {{ $ward->type }}
                        </span>
                    </div>
                </div>
                <div class="block-content">
                    <p class="text-muted mb-2">{{ $ward->description ?? 'No description' }}</p>
                    <div class="row text-center mb-3">
                        <div class="col-4">
                            <div class="font-size-h4 font-w600">{{ $ward->capacity }}</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Capacity</div>
                        </div>
                        <div class="col-4">
                            <div class="font-size-h4 font-w600">{{ $ward->beds_count }}</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Beds</div>
                        </div>
                        <div class="col-4">
                            <div class="font-size-h4 font-w600 text-success">{{ $ward->available_beds_count }}</div>
                            <div class="font-size-sm font-w600 text-uppercase text-muted">Free</div>
                        </div>
                    </div>
                </div>
                <div class="block-content block-content-full block-content-sm bg-body-light text-center">
                    <a href="{{ route('wards.show', $ward) }}" class="btn btn-sm btn-alt-primary">
                        <i class="fa fa-bed mr-1"></i> Manage Beds
                    </a>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                No wards found. Please create a new ward.
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
