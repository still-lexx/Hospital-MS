@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Test Request Details</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                @if($labTestRequest->status != 'completed' && $labTestRequest->status != 'cancelled')
                    <a href="{{ route('lab-test-requests.edit', $labTestRequest) }}" class="btn btn-warning">
                        <i class="fa fa-edit"></i> Edit
                    </a>
                @endif
                @if(!$labTestRequest->result)
                    <a href="{{ route('lab-results.create', ['request' => $labTestRequest->id]) }}" class="btn btn-success">
                        <i class="fa fa-plus"></i> Add Result
                    </a>
                @endif
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Request Information</h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Patient:</strong> {{ $labTestRequest->patient->name }}</p>
                    <p><strong>Test:</strong> {{ $labTestRequest->labTest->name }}</p>
                    <p><strong>Doctor:</strong> {{ $labTestRequest->doctor->name ?? 'Not assigned' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Request Date:</strong> {{ $labTestRequest->request_date->format('M d, Y') }}</p>
                    <p><strong>Priority:</strong> <span class="badge badge-{{ $labTestRequest->priority == 'stat' ? 'danger' : ($labTestRequest->priority == 'urgent' ? 'warning' : 'info') }}">{{ strtoupper($labTestRequest->priority) }}</span></p>
                    <p><strong>Status:</strong> <span class="badge badge-{{ $labTestRequest->status == 'completed' ? 'success' : ($labTestRequest->status == 'in-progress' ? 'warning' : 'secondary') }}">{{ ucfirst($labTestRequest->status) }}</span></p>
                </div>
            </div>
            @if($labTestRequest->notes)
            <div class="row mt-3">
                <div class="col-12">
                    <p><strong>Notes:</strong></p>
                    <p>{{ $labTestRequest->notes }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    @if($labTestRequest->result)
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Test Result</h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Result Value:</strong> {{ $labTestRequest->result->result_value }}</p>
                    <p><strong>Result Date:</strong> {{ $labTestRequest->result->result_date->format('M d, Y H:i') }}</p>
                    <p><strong>Performed By:</strong> {{ $labTestRequest->result->performedBy->name ?? 'N/A' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Status:</strong> <span class="badge badge-{{ $labTestRequest->result->status == 'normal' ? 'success' : ($labTestRequest->result->status == 'abnormal' ? 'warning' : 'danger') }}">{{ ucfirst($labTestRequest->result->status) }}</span></p>
                    <p><strong>Normal Range:</strong> {{ $labTestRequest->labTest->normal_range ?? '-' }} {{ $labTestRequest->labTest->unit }}</p>
                </div>
            </div>
            @if($labTestRequest->result->remarks)
            <div class="row mt-3">
                <div class="col-12">
                    <p><strong>Remarks:</strong></p>
                    <p>{{ $labTestRequest->result->remarks }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection
