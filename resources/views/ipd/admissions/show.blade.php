@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Admission Details</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                @if($ipdAdmission->status == 'admitted')
                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-discharge">
                    <i class="fa fa-sign-out-alt"></i> Discharge Patient
                </button>
                @endif
                <a href="{{ route('ipd-admissions.index') }}" class="btn btn-secondary">Back</a>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Patient Information</h3>
            <div class="block-options">
                <span class="badge badge-{{ $ipdAdmission->status == 'admitted' ? 'success' : 'secondary' }}">
                    {{ ucfirst($ipdAdmission->status) }}
                </span>
            </div>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Patient:</strong> {{ $ipdAdmission->patient->name }}</p>
                    <p><strong>Doctor:</strong> {{ $ipdAdmission->doctor->name }}</p>
                    <p><strong>Admission Date:</strong> {{ $ipdAdmission->admission_date->format('M d, Y H:i') }}</p>
                    @if($ipdAdmission->discharge_date)
                    <p><strong>Discharge Date:</strong> {{ $ipdAdmission->discharge_date->format('M d, Y H:i') }}</p>
                    @endif
                </div>
                <div class="col-md-6">
                    <p><strong>Ward:</strong> {{ $ipdAdmission->bed->ward->name }}</p>
                    <p><strong>Bed Number:</strong> {{ $ipdAdmission->bed->bed_number }}</p>
                    <p><strong>Daily Charge:</strong> ₦{{ number_format($ipdAdmission->bed->daily_charge, 2) }}</p>
                    <p><strong>Deposit:</strong> ₦{{ number_format($ipdAdmission->deposit_amount, 2) }}</p>
                </div>
            </div>
            
            <div class="mt-3">
                <h5>Reason for Admission</h5>
                <p>{{ $ipdAdmission->reason }}</p>
            </div>

            @if($ipdAdmission->discharge_summary)
            <div class="mt-3">
                <h5>Discharge Summary</h5>
                <div class="alert alert-secondary">
                    {{ $ipdAdmission->discharge_summary }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- Discharge Modal -->
<div class="modal fade" id="modal-discharge" tabindex="-1" role="dialog" aria-labelledby="modal-discharge" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('ipd-admissions.discharge', $ipdAdmission) }}" method="POST">
                @csrf
                <div class="block block-rounded block-themed block-transparent mb-0">
                    <div class="block-header bg-danger">
                        <h3 class="block-title">Discharge Patient</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <div class="block-content font-size-sm">
                        <div class="form-group">
                            <label>Discharge Date <span class="text-danger">*</span></label>
                            <input type="datetime-local" class="form-control" name="discharge_date" value="{{ now()->format('Y-m-d\TH:i') }}" required>
                        </div>
                        <div class="form-group">
                            <label>Discharge Summary <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="discharge_summary" rows="4" required placeholder="Clinical notes, medication instructions, etc."></textarea>
                        </div>
                    </div>
                    <div class="block-content block-content-full text-right border-top">
                        <button type="button" class="btn btn-alt-primary mr-1" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-danger">Confirm Discharge</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
