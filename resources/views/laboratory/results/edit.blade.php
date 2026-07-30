@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">{{ isset($labResult) ? 'Edit' : 'Add' }} Lab Result</h1>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ isset($labResult) ? route('lab-results.update', $labResult) : route('lab-results.store') }}" method="POST">
                @csrf
                @if(isset($labResult))
                    @method('PUT')
                @else
                <div class="form-group">
                    <label>Test Request <span class="text-danger">*</span></label>
                    <select class="form-control" name="lab_test_request_id" required>
                        <option value="">Select Request</option>
                        @foreach($pendingRequests as $request)
                            <option value="{{ $request->id }}" {{ old('lab_test_request_id') == $request->id ? 'selected' : '' }}>
                                {{ $request->patient->name }} - {{ $request->labTest->name }} ({{ $request->request_date->format('M d, Y') }})
                            </option>
                        @endforeach
                    </select>
                </div>
                @endif

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Result Value <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="result_value" value="{{ old('result_value', $labResult->result_value ?? '') }}" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Result Date <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="result_date" value="{{ old('result_date', isset($labResult) ? $labResult->result_date->format('Y-m-d\TH:i') : now()->format('Y-m-d\TH:i')) }}" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Status <span class="text-danger">*</span></label>
                    <select class="form-control" name="status" required>
                        <option value="normal" {{ old('status', $labResult->status ?? 'normal') == 'normal' ? 'selected' : '' }}>Normal</option>
                        <option value="abnormal" {{ old('status', $labResult->status ?? '') == 'abnormal' ? 'selected' : '' }}>Abnormal</option>
                        <option value="critical" {{ old('status', $labResult->status ?? '') == 'critical' ? 'selected' : '' }}>Critical</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Remarks</label>
                    <textarea class="form-control" name="remarks" rows="4">{{ old('remarks', $labResult->remarks ?? '') }}</textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">{{ isset($labResult) ? 'Update' : 'Save' }} Result</button>
                    <a href="{{ route('lab-results.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
