@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Edit Insurance Claim</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('insurance-claims.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left"></i> Back
                </a>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('insurance-claims.update', $insuranceClaim) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="patient_id">Patient <span class="text-danger">*</span></label>
                            <select class="form-control" id="patient_id" name="patient_id" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" 
                                        {{ old('patient_id', $insuranceClaim->patient_id) == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('patient_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="invoice_id">Invoice <span class="text-danger">*</span></label>
                            <select class="form-control" id="invoice_id" name="invoice_id" required>
                                <option value="">Select Invoice</option>
                                @foreach($invoices as $invoice)
                                    <option value="{{ $invoice->id }}" 
                                        {{ old('invoice_id', $insuranceClaim->invoice_id) == $invoice->id ? 'selected' : '' }}>
                                        #{{ $invoice->id }} - {{ $invoice->patient->name }} - ₦{{ number_format($invoice->total_amount, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('invoice_id')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="provider_name">Insurance Provider <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="provider_name" name="provider_name" 
                                   value="{{ old('provider_name', $insuranceClaim->provider_name) }}" required>
                            @error('provider_name')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="policy_number">Policy Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="policy_number" name="policy_number" 
                                   value="{{ old('policy_number', $insuranceClaim->policy_number) }}" required>
                            @error('policy_number')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="claim_number">Claim Number</label>
                            <input type="text" class="form-control" id="claim_number" name="claim_number" 
                                   value="{{ old('claim_number', $insuranceClaim->claim_number) }}">
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="status">Status <span class="text-danger">*</span></label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="pending" {{ old('status', $insuranceClaim->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="approved" {{ old('status', $insuranceClaim->status) == 'approved' ? 'selected' : '' }}>Approved</option>
                                <option value="rejected" {{ old('status', $insuranceClaim->status) == 'rejected' ? 'selected' : '' }}>Rejected</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="claim_amount">Claim Amount (₦) <span class="text-danger">*</span></label>
                            <input type="number" step="0.01" class="form-control" id="claim_amount" name="claim_amount" 
                                   value="{{ old('claim_amount', $insuranceClaim->claim_amount) }}" required>
                            @error('claim_amount')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="approved_amount">Approved Amount (₦)</label>
                            <input type="number" step="0.01" class="form-control" id="approved_amount" name="approved_amount" 
                                   value="{{ old('approved_amount', $insuranceClaim->approved_amount) }}">
                            <small class="form-text text-muted">Leave empty if not yet approved</small>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Update Claim
                    </button>
                    <a href="{{ route('insurance-claims.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
