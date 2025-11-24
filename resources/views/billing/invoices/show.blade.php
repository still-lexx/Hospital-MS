@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Invoice #{{ $invoice->id }}</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('invoices.print', $invoice) }}" class="btn btn-secondary" target="_blank">
                    <i class="fa fa-print"></i> Print
                </a>
                @if(in_array($invoice->status, ['draft', 'unpaid']))
                <a href="{{ route('invoices.edit', $invoice) }}" class="btn btn-warning">
                    <i class="fa fa-pencil-alt"></i> Edit
                </a>
                @endif
                <a href="{{ route('invoices.index') }}" class="btn btn-primary">
                    <i class="fa fa-arrow-left"></i> Back to List
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible" role="alert">
            <button type="button" class="close" data-dismiss="alert">×</button>
            {{ session('error') }}
        </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- Invoice Details -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Invoice Details</h3>
                    <div class="block-options">
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
                    </div>
                </div>
                <div class="block-content">
                    <div class="row mb-3">
                        <div class="col-6">
                            <p class="font-size-sm text-muted mb-1">Patient</p>
                            <p class="font-w600">{{ $invoice->patient->name }}</p>
                            <p class="font-size-sm">{{ $invoice->patient->phone }}</p>
                        </div>
                        <div class="col-6">
                            <p class="font-size-sm text-muted mb-1">Doctor</p>
                            <p class="font-w600">{{ $invoice->doctor ? $invoice->doctor->user->name : 'N/A' }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <p class="font-size-sm text-muted mb-1">Invoice Date</p>
                            <p>{{ $invoice->invoice_date->format('M d, Y') }}</p>
                        </div>
                        <div class="col-6">
                            <p class="font-size-sm text-muted mb-1">Due Date</p>
                            <p>{{ $invoice->due_date ? $invoice->due_date->format('M d, Y') : 'N/A' }}</p>
                        </div>
                    </div>

                    @if($invoice->notes)
                    <div class="mb-3">
                        <p class="font-size-sm text-muted mb-1">Notes</p>
                        <p>{{ $invoice->notes }}</p>
                    </div>
                    @endif

                    <!-- Invoice Items -->
                    <h5 class="mt-4 mb-3">Items</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Description</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-right">Unit Price</th>
                                    <th class="text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->items as $item)
                                <tr>
                                    <td>{{ $item->description }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-right">₦{{ number_format($item->unit_price, 2) }}</td>
                                    <td class="text-right">₦{{ number_format($item->total, 2) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="3" class="text-right"><strong>Subtotal:</strong></td>
                                    <td class="text-right">₦{{ number_format($invoice->items->sum('total'), 2) }}</td>
                                </tr>
                                @if($invoice->tax_amount > 0)
                                <tr>
                                    <td colspan="3" class="text-right">Tax:</td>
                                    <td class="text-right">₦{{ number_format($invoice->tax_amount, 2) }}</td>
                                </tr>
                                @endif
                                @if($invoice->discount_amount > 0)
                                <tr>
                                    <td colspan="3" class="text-right">Discount:</td>
                                    <td class="text-right">-₦{{ number_format($invoice->discount_amount, 2) }}</td>
                                </tr>
                                @endif
                                <tr class="table-active">
                                    <td colspan="3" class="text-right"><strong>Total Amount:</strong></td>
                                    <td class="text-right"><strong>₦{{ number_format($invoice->total_amount, 2) }}</strong></td>
                                </tr>
                                <tr class="table-success">
                                    <td colspan="3" class="text-right"><strong>Paid Amount:</strong></td>
                                    <td class="text-right"><strong>₦{{ number_format($invoice->paid_amount, 2) }}</strong></td>
                                </tr>
                                <tr class="table-warning">
                                    <td colspan="3" class="text-right"><strong>Balance Due:</strong></td>
                                    <td class="text-right"><strong>₦{{ number_format($invoice->balance, 2) }}</strong></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Payment History -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Payment History</h3>
                    @if($invoice->balance > 0 && $invoice->status != 'cancelled')
                    <div class="block-options">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#paymentModal">
                            <i class="fa fa-plus"></i> Add Payment
                        </button>
                    </div>
                    @endif
                </div>
                <div class="block-content">
                    @forelse($invoice->payments as $payment)
                    <div class="mb-3 pb-3 border-bottom">
                        <div class="d-flex justify-content-between">
                            <strong>₦{{ number_format($payment->amount, 2) }}</strong>
                            <span class="badge badge-success">{{ ucfirst($payment->payment_method) }}</span>
                        </div>
                        <p class="font-size-sm text-muted mb-0">{{ $payment->payment_date->format('M d, Y') }}</p>
                        @if($payment->transaction_reference)
                        <p class="font-size-sm mb-0">Ref: {{ $payment->transaction_reference }}</p>
                        @endif
                    </div>
                    @empty
                    <p class="text-muted">No payments recorded yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                
                <div class="modal-header">
                    <h5 class="modal-title">Record Payment</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Amount (₦) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" class="form-control" name="amount" 
                               max="{{ $invoice->balance }}" value="{{ $invoice->balance }}" required>
                        <small class="form-text text-muted">Maximum: ₦{{ number_format($invoice->balance, 2) }}</small>
                    </div>

                    <div class="form-group">
                        <label>Payment Date <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" name="payment_date" 
                               value="{{ date('Y-m-d') }}" required>
                    </div>

                    <div class="form-group">
                        <label>Payment Method <span class="text-danger">*</span></label>
                        <select class="form-control" name="payment_method" required>
                            <option value="cash">Cash</option>
                            <option value="card">Card</option>
                            <option value="transfer">Bank Transfer</option>
                            <option value="insurance">Insurance</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Transaction Reference</label>
                        <input type="text" class="form-control" name="transaction_reference">
                    </div>

                    <div class="form-group">
                        <label>Notes</label>
                        <textarea class="form-control" name="notes" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Record Payment</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
