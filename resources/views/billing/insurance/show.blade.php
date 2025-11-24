@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Insurance Claim Details</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                @if($insuranceClaim->status == 'pending')
                <a href="{{ route('insurance-claims.edit', $insuranceClaim) }}" class="btn btn-warning">
                    <i class="fa fa-pencil-alt"></i> Edit
                </a>
                @endif
                <a href="{{ route('insurance-claims.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session('success') }}
        </div>
    @endif

    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Claim Information</h3>
            <div class="block-options">
                @if($insuranceClaim->status == 'approved')
                    <span class="badge badge-success">Approved</span>
                @elseif($insuranceClaim->status == 'rejected')
                    <span class="badge badge-danger">Rejected</span>
                @else
                    <span class="badge badge-warning">Pending</span>
                @endif
            </div>
        </div>
        <div class="block-content">
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="font-size-sm text-muted mb-1">Patient</p>
                    <p class="font-w600">{{ $insuranceClaim->patient->name }}</p>
                </div>
                <div class="col-md-6">
                    <p class="font-size-sm text-muted mb-1">Invoice</p>
                    <p><a href="{{ route('invoices.show', $insuranceClaim->invoice) }}">#{{ $insuranceClaim->invoice_id }}</a></p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="font-size-sm text-muted mb-1">Insurance Provider</p>
                    <p>{{ $insuranceClaim->provider_name }}</p>
                </div>
                <div class="col-md-6">
                    <p class="font-size-sm text-muted mb-1">Policy Number</p>
                    <p>{{ $insuranceClaim->policy_number }}</p>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="font-size-sm text-muted mb-1">Claim Number</p>
                    <p>{{ $insuranceClaim->claim_number ?? 'Not assigned yet' }}</p>
                </div>
                <div class="col-md-6">
                    <p class="font-size-sm text-muted mb-1">Status</p>
                    <p>
                        @if($insuranceClaim->status == 'approved')
                            <span class="badge badge-success">Approved</span>
                        @elseif($insuranceClaim->status == 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @else
                            <span class="badge badge-warning">Pending</span>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p class="font-size-sm text-muted mb-1">Claim Amount</p>
                    <p class="font-w600 font-size-h4">₦{{ number_format($insuranceClaim->claim_amount, 2) }}</p>
                </div>
                @if($insuranceClaim->approved_amount)
                <div class="col-md-6">
                    <p class="font-size-sm text-muted mb-1">Approved Amount</p>
                    <p class="font-w600 font-size-h4 text-success">₦{{ number_format($insuranceClaim->approved_amount, 2) }}</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
