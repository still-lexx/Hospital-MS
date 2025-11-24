@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Create Invoice</h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('invoices.index') }}">Invoices</a></li>
                    <li class="breadcrumb-item" aria-current="page">Create</li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('invoices.store') }}" method="POST" id="invoiceForm">
                @csrf
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="patient_id">Patient <span class="text-danger">*</span></label>
                            <select class="form-control" id="patient_id" name="patient_id" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}" {{ old('patient_id') == $patient->id ? 'selected' : '' }}>
                                        {{ $patient->name }} - {{ $patient->phone }}
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
                            <label for="doctor_id">Doctor</label>
                            <select class="form-control" id="doctor_id" name="doctor_id">
                                <option value="">Select Doctor (Optional)</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}" {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                                        {{ $doctor->user->name }} - {{ $doctor->specialization }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="invoice_date">Invoice Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="invoice_date" name="invoice_date" 
                                   value="{{ old('invoice_date', date('Y-m-d')) }}" required>
                            @error('invoice_date')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="due_date">Due Date</label>
                            <input type="date" class="form-control" id="due_date" name="due_date" 
                                   value="{{ old('due_date') }}">
                        </div>
                    </div>
                </div>

                <!-- Invoice Items -->
                <div class="form-group">
                    <label class="d-block">Invoice Items <span class="text-danger">*</span></label>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="itemsTable">
                            <thead>
                                <tr>
                                    <th width="45%">Description</th>
                                    <th width="15%">Quantity</th>
                                    <th width="20%">Unit Price (₦)</th>
                                    <th width="15%">Total (₦)</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="itemsBody">
                                <tr class="item-row">
                                    <td><input type="text" class="form-control" name="items[0][description]" required></td>
                                    <td><input type="number" class="form-control item-quantity" name="items[0][quantity]" value="1" min="1" required></td>
                                    <td><input type="number" step="0.01" class="form-control item-price" name="items[0][unit_price]" required></td>
                                    <td><input type="text" class="form-control item-total" readonly></td>
                                    <td><button type="button" class="btn btn-sm btn-danger remove-item">×</button></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <button type="button" class="btn btn-sm btn-primary" id="addItem">
                        <i class="fa fa-plus"></i> Add Item
                    </button>
                </div>

                <!-- Totals -->
                <div class="row">
                    <div class="col-md-8"></div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Subtotal</label>
                            <input type="text" class="form-control" id="subtotal" readonly value="₦0.00">
                        </div>
                        <div class="form-group">
                            <label for="tax_amount">Tax Amount (₦)</label>
                            <input type="number" step="0.01" class="form-control" id="tax_amount" name="tax_amount" value="0">
                        </div>
                        <div class="form-group">
                            <label for="discount_amount">Discount Amount (₦)</label>
                            <input type="number" step="0.01" class="form-control" id="discount_amount" name="discount_amount" value="0">
                        </div>
                        <div class="form-group">
                            <label>Total Amount</label>
                            <input type="text" class="form-control font-w700" id="total" readonly value="₦0.00">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes">Notes</label>
                    <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Create Invoice
                    </button>
                    <a href="{{ route('invoices.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;

    // Add new item row
    const addItemBtn = document.getElementById('addItem');
    if (addItemBtn) {
        addItemBtn.addEventListener('click', function() {
            const tbody = document.getElementById('itemsBody');
            const newRow = document.createElement('tr');
            newRow.className = 'item-row';
            newRow.innerHTML = `
                <td><input type="text" class="form-control" name="items[${itemIndex}][description]" required></td>
                <td><input type="number" class="form-control item-quantity" name="items[${itemIndex}][quantity]" value="1" min="1" required></td>
                <td><input type="number" step="0.01" class="form-control item-price" name="items[${itemIndex}][unit_price]" required></td>
                <td><input type="text" class="form-control item-total" readonly></td>
                <td><button type="button" class="btn btn-sm btn-danger remove-item">×</button></td>
            `;
            tbody.appendChild(newRow);
            itemIndex++;
            attachItemListeners(newRow);
        });
    }

    // Remove item row
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-item')) {
            const rows = document.querySelectorAll('.item-row');
            if (rows.length > 1) {
                e.target.closest('tr').remove();
                calculateTotals();
            }
        }
    });

    // Calculate item total
    function attachItemListeners(row) {
        const quantity = row.querySelector('.item-quantity');
        const price = row.querySelector('.item-price');
        const total = row.querySelector('.item-total');

        function updateTotal() {
            const qty = parseFloat(quantity.value) || 0;
            const prc = parseFloat(price.value) || 0;
            const tot = qty * prc;
            total.value = '₦' + tot.toFixed(2);
            calculateTotals();
        }

        quantity.addEventListener('input', updateTotal);
        price.addEventListener('input', updateTotal);
    }

    // Calculate all totals
    function calculateTotals() {
        let subtotal = 0;
        document.querySelectorAll('.item-row').forEach(row => {
            const qty = parseFloat(row.querySelector('.item-quantity').value) || 0;
            const price = parseFloat(row.querySelector('.item-price').value) || 0;
            subtotal += qty * price;
        });

        const tax = parseFloat(document.getElementById('tax_amount').value) || 0;
        const discount = parseFloat(document.getElementById('discount_amount').value) || 0;
        const total = subtotal + tax - discount;

        document.getElementById('subtotal').value = '₦' + subtotal.toFixed(2);
        document.getElementById('total').value = '₦' + total.toFixed(2);
    }

    // Attach listeners to initial row
    document.querySelectorAll('.item-row').forEach(row => {
        attachItemListeners(row);
    });

    // Recalculate on tax/discount change
    document.getElementById('tax_amount').addEventListener('input', calculateTotals);
    document.getElementById('discount_amount').addEventListener('input', calculateTotals);
});
</script>
@endsection
