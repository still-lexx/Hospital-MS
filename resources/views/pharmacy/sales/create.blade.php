@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">New Sale</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('pharmacy-sales.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Patient <span class="text-danger">*</span></label>
                            <select class="form-control" name="patient_id" required>
                                <option value="">Select Patient</option>
                                @foreach($patients as $patient)
                                    <option value="{{ $patient->id }}">{{ $patient->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Sale Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" name="sale_date" value="{{ date('Y-m-d') }}" required>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Payment Method <span class="text-danger">*</span></label>
                            <select class="form-control" name="payment_method" required>
                                <option value="cash">Cash</option>
                                <option value="card">Card</option>
                                <option value="insurance">Insurance</option>
                                <option value="transfer">Transfer</option>
                            </select>
                        </div>
                    </div>
                </div>

                <h4 class="mt-3">Items</h4>
                <table class="table table-bordered" id="itemsTable">
                    <thead>
                        <tr>
                            <th>Medicine</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        <tr class="item-row">
                            <td>
                                <select class="form-control medicine-select" name="items[0][inventory_item_id]" required>
                                    <option value="">Select Medicine</option>
                                    @foreach($medicines as $medicine)
                                        <option value="{{ $medicine->id }}" data-price="{{ optional($medicine->stocks->first())->unit_price ?? 0 }}">{{ $medicine->name }} (Stock: {{ $medicine->stocks->sum('quantity') }})</option>
                                    @endforeach
                                </select>
                            </td>
                            <td><input type="number" class="form-control quantity-input" name="items[0][quantity]" value="1" min="1" required></td>
                            <td><input type="number" step="0.01" class="form-control price-input" name="items[0][unit_price]" required></td>
                            <td><input type="number" step="0.01" class="form-control total-input" readonly></td>
                            <td><button type="button" class="btn btn-sm btn-danger remove-item" disabled>×</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-success" id="addItem">+ Add Item</button>

                <div class=" form-group mt-3">
                    <button type="submit" class="btn btn-primary">Complete Sale</button>
                    <a href="{{ route('pharmacy-sales.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
let itemIndex = 1;

document.getElementById('addItem').addEventListener('click', function() {
    const tbody = document.getElementById('itemsBody');
    const row = document.createElement('tr');
    row.className = 'item-row';
    row.innerHTML = `
        <td>
            <select class="form-control medicine-select" name="items[${itemIndex}][inventory_item_id]" required>
                <option value="">Select Medicine</option>
                @foreach($medicines as $medicine)
                    <option value="{{ $medicine->id }}" data-price="{{ optional($medicine->stocks->first())->unit_price ?? 0 }}">{{ $medicine->name }} (Stock: {{ $medicine->stocks->sum('quantity') }})</option>
                @endforeach
            </select>
        </td>
        <td><input type="number" class="form-control quantity-input" name="items[${itemIndex}][quantity]" value="1" min="1" required></td>
        <td><input type="number" step="0.01" class="form-control price-input" name="items[${itemIndex}][unit_price]" required></td>
        <td><input type="number" step="0.01" class="form-control total-input" readonly></td>
        <td><button type="button" class="btn btn-sm btn-danger remove-item">×</button></td>
    `;
    tbody.appendChild(row);
    itemIndex++;
    attachRowEvents(row);
    updateRemoveButtons();
});

document.getElementById('itemsBody').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item')) {
        e.target.closest('tr').remove();
        updateRemoveButtons();
    }
});

function attachRowEvents(row) {
    const select = row.querySelector('.medicine-select');
    const qtyInput = row.querySelector('.quantity-input');
    const priceInput = row.querySelector('.price-input');
    const totalInput = row.querySelector('.total-input');

    select.addEventListener('change', function() {
        const price = this.options[this.selectedIndex].getAttribute('data-price');
        priceInput.value = price || 0;
        calculateTotal(row);
    });

    qtyInput.addEventListener('input', () => calculateTotal(row));
    priceInput.addEventListener('input', () => calculateTotal(row));
}

function calculateTotal(row) {
    const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
    const price = parseFloat(row.querySelector('.price-input').value) || 0;
    row.querySelector('.total-input').value = (qty * price).toFixed(2);
}

function updateRemoveButtons() {
    const rows = document.querySelectorAll('.item-row');
    rows.forEach(row => {
        row.querySelector('.remove-item').disabled = rows.length === 1;
    });
}

// Attach events to initial row
document.querySelectorAll('.item-row').forEach(row => attachRowEvents(row));
</script>
@endsection
