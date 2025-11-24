@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Create Purchase Order
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Inventory</li>
                    <li class="breadcrumb-item">
                        <a class="link-fx" href="{{ route('purchase-orders.index') }}">Purchase Orders</a>
                    </li>
                    <li class="breadcrumb-item" aria-current="page">
                        Create
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <form action="{{ route('purchase-orders.store') }}" method="POST" id="po-form">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">Order Details</h3>
                    </div>
                    <div class="block-content">
                        <div class="form-group">
                            <label for="order_number">Order Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="order_number" name="order_number" value="{{ old('order_number', $orderNumber) }}" readonly>
                        </div>
                        <div class="form-group">
                            <label for="supplier_id">Supplier <span class="text-danger">*</span></label>
                            <select class="form-control" id="supplier_id" name="supplier_id" required>
                                <option value="">Select Supplier</option>
                                @foreach($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="order_date">Order Date <span class="text-danger">*</span></label>
                            <input type="date" class="form-control" id="order_date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="expected_delivery">Expected Delivery</label>
                            <input type="date" class="form-control" id="expected_delivery" name="expected_delivery" value="{{ old('expected_delivery') }}">
                        </div>
                        <div class="form-group">
                            <label for="notes">Notes</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes') }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="block block-rounded">
                    <div class="block-header">
                        <h3 class="block-title">Order Items</h3>
                        <div class="block-options">
                            <button type="button" class="btn btn-sm btn-primary" id="add-item">
                                <i class="fa fa-plus mr-1"></i> Add Item
                            </button>
                        </div>
                    </div>
                    <div class="block-content">
                        <div class="table-responsive">
                            <table class="table table-bordered table-vcenter" id="items-table">
                                <thead>
                                    <tr>
                                        <th style="width: 40%;">Item</th>
                                        <th style="width: 20%;">Quantity</th>
                                        <th style="width: 20%;">Unit Price</th>
                                        <th style="width: 15%;">Total</th>
                                        <th style="width: 5%;"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr id="item-row-0">
                                        <td>
                                            <select class="form-control item-select" name="items[0][inventory_item_id]" required>
                                                <option value="">Select Item</option>
                                                @foreach($inventoryItems as $item)
                                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->sku }})</option>
                                                @endforeach
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control quantity-input" name="items[0][quantity]" min="1" value="1" required>
                                        </td>
                                        <td>
                                            <input type="number" class="form-control price-input" name="items[0][unit_price]" min="0" step="0.01" value="0.00" required>
                                        </td>
                                        <td>
                                            <span class="row-total">0.00</span>
                                        </td>
                                        <td class="text-center">
                                            <button type="button" class="btn btn-sm btn-danger remove-item" disabled>
                                                <i class="fa fa-times"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="3" class="text-right font-w700">Total Amount:</td>
                                        <td class="font-w700" id="grand-total">0.00</td>
                                        <td></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
                
                <div class="block block-rounded">
                    <div class="block-content block-content-full text-right">
                        <a href="{{ route('purchase-orders.index') }}" class="btn btn-alt-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary" onclick="return validateForm();">Create Order</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    let itemIndex = 1;
    const tableBody = document.querySelector('#items-table tbody');
    const addItemBtn = document.getElementById('add-item');
    const grandTotalEl = document.getElementById('grand-total');

    // Calculate totals
    function calculateTotals() {
        let grandTotal = 0;
        document.querySelectorAll('#items-table tbody tr').forEach(row => {
            const qty = parseFloat(row.querySelector('.quantity-input').value) || 0;
            const price = parseFloat(row.querySelector('.price-input').value) || 0;
            const total = qty * price;
            
            row.querySelector('.row-total').textContent = total.toFixed(2);
            grandTotal += total;
        });
        grandTotalEl.textContent = grandTotal.toFixed(2);
    }

    // Add new row
    addItemBtn.addEventListener('click', function() {
        const firstRow = tableBody.querySelector('tr').cloneNode(true);
        firstRow.id = 'item-row-' + itemIndex;
        
        // Update names
        firstRow.querySelector('.item-select').name = `items[${itemIndex}][inventory_item_id]`;
        firstRow.querySelector('.item-select').value = '';
        firstRow.querySelector('.quantity-input').name = `items[${itemIndex}][quantity]`;
        firstRow.querySelector('.quantity-input').value = '1';
        firstRow.querySelector('.price-input').name = `items[${itemIndex}][unit_price]`;
        firstRow.querySelector('.price-input').value = '0.00';
        firstRow.querySelector('.row-total').textContent = '0.00';
        
        // Enable remove button
        const removeBtn = firstRow.querySelector('.remove-item');
        removeBtn.disabled = false;
        removeBtn.addEventListener('click', function() {
            firstRow.remove();
            calculateTotals();
            updateRemoveButtons();
        });

        tableBody.appendChild(firstRow);
        itemIndex++;
        
        // Re-attach event listeners
        attachListeners(firstRow);
        updateRemoveButtons();
    });

    // Update remove button states
    function updateRemoveButtons() {
        const rows = tableBody.querySelectorAll('tr');
        rows.forEach((row, index) => {
            const removeBtn = row.querySelector('.remove-item');
            removeBtn.disabled = rows.length === 1;
        });
    }

    // Attach listeners to inputs
    function attachListeners(row) {
        row.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', calculateTotals);
        });
    }

    // Initial listeners
    attachListeners(tableBody.querySelector('tr'));

    // Form validation
    window.validateForm = function() {
        const supplierSelect = document.getElementById('supplier_id');
        if (!supplierSelect.value) {
            alert('Please select a supplier');
            supplierSelect.focus();
            return false;
        }

        const rows = tableBody.querySelectorAll('tr');
        let hasValidItem = false;
        
        for (let row of rows) {
            const itemSelect = row.querySelector('.item-select');
            if (itemSelect.value) {
                hasValidItem = true;
                break;
            }
        }

        if (!hasValidItem) {
            alert('Please add at least one item to the purchase order');
            return false;
        }

        return true;
    };
});
</script>
@endsection
