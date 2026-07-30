@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Invoices</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('invoices.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Create Invoice
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
            <h3 class="block-title">Invoice List</h3>
        </div>
        <div class="block-content">
            <!-- Filters -->
            <form method="GET" class="mb-3">
                <div class="row">
                    <div class="col-md-3">
                        <select name="status" class="form-control">
                            <option value="">All Status</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Partial</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}" placeholder="Start Date">
                    </div>
                    <div class="col-md-3">
                        <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}" placeholder="End Date">
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary">Filter</button>
                        <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Clear</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped table-vcenter">
                    <thead>
                        <tr>
                            <th>Invoice #</th>
                            <th>Patient</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                        <tr>
                            <td><strong>#{{ $invoice->id }}</strong></td>
                            <td>{{ $invoice->patient->name }}</td>
                            <td>{{ $invoice->invoice_date->format('M d, Y') }}</td>
                            <td>₦{{ number_format($invoice->total_amount, 2) }}</td>
                            <td>
                                @if($invoice->status == 'paid')
                                    <span class="badge badge-success">Paid</span>
                                @elseif($invoice->status == 'partial')
                                    <span class="badge badge-warning">Partial</span>
                                @elseif($invoice->status == 'unpaid')
                                    <span class="badge badge-danger">Unpaid</span>
                                @elseif($invoice->status == 'draft')
                                    <span class="badge badge-secondary">Draft</span>
                                @else
                                    <span class="badge badge-dark">Cancelled</span>
                                @endif
                            </td>
                            <td class="text-right">
                                <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info" title="View">
                                    <i class="fa fa-eye"></i>
                                </a>
                                @if(in_array($invoice->status, ['draft', 'unpaid']))
                                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-sm btn-warning" title="Edit">
                                    <i class="fa fa-pencil-alt"></i>
                                </a>
                                @endif
                                <a href="{{ route('invoices.print', $invoice) }}" class="btn btn-sm btn-secondary" target="_blank" title="Print">
                                    <i class="fa fa-print"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">No invoices found.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $invoices->links() }}
            </div>
        </div>
    </div>
</div>
@endsection
