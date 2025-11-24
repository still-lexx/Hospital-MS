@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Insurance Claims</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('insurance-claims.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> New Claim
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
            <h3 class="block-title">Claims List</h3>
        </div>
        <div class="block-content">
            <!-- Filters -->
            <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-4">
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('insurance-claims.index') }}" class="btn btn-secondary">Clear</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Claim #</th>
                            <th>Patient</th>
                            <th>Invoice</th>
                            <th>Provider</th>
                            <th>Policy Number</th>
                            <th>Claim Amount</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($claims as $claim)
                        <tr>
                            <td><strong>{{ $claim->claim_number ?? 'Pending' }}</strong></td>
                            <td>{{ $claim->patient->name }}</td>
                            <td>
                                <a href="{{ route('invoices.show', $claim->invoice) }}">#{{ $claim->invoice_id }}</a>
                            </td>
                            <td>{{ $claim->provider_name }}</td>
                            <td>{{ $claim->policy_number }}</td>
                            <td>₦{{ number_format($claim->claim_amount, 2) }}</td>
                            <td>
                                @if($claim->status == 'approved')
                                    <span class="badge badge-success">Approved</span>
                                    @if($claim->approved_amount)
                                        <br><small>Approved: ₦{{ number_format($claim->approved_amount, 2) }}</small>
                                    @endif
                                @elseif($claim->status == 'rejected')
                                    <span class="badge badge-danger">Rejected</span>
                                @else
                                    <span class="badge badge-warning">Pending</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('insurance-claims.show', $claim) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if($claim->status == 'pending')
                                <a href="{{ route('insurance-claims.edit', $claim) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">No insurance claims found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $claims->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
