@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">New Prescription</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('prescriptions.store') }}" method="POST" id="prescriptionForm">
                @csrf

                <div class="row">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Doctor</label>
                            <select class="form-control" name="doctor_id">
                                <option value="">Select Doctor</option>
                                @foreach($doctors as $doctor)
                                    <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Prescription Date <span class="text-danger">*</span></label>
                    <input type="date" class="form-control" name="prescription_date" value="{{ date('Y-m-d') }}" required>
                </div>

                <h4 class="mt-4">Medicines</h4>
                <table class="table table-bordered" id="itemsTable">
                    <thead>
                        <tr>
                            <th>Medicine Name</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Quantity</th>
                            <th>Instructions</th>
                            <th width="50">Action</th>
                        </tr>
                    </thead>
                    <tbody id="itemsBody">
                        <tr>
                            <td><input type="text" class="form-control" name="items[0][medicine_name]" required></td>
                            <td><input type="text" class="form-control" name="items[0][dosage]" required></td>
                            <td><input type="text" class="form-control" name="items[0][frequency]" required></td>
                            <td><input type="text" class="form-control" name="items[0][duration]" required></td>
                            <td><input type="number" class="form-control" name="items[0][quantity]" required></td>
                            <td><input type="text" class="form-control" name="items[0][instructions]"></td>
                            <td><button type="button" class="btn btn-sm btn-danger remove-item" disabled>×</button></td>
                        </tr>
                    </tbody>
                </table>
                <button type="button" class="btn btn-sm btn-success" id="addItem">+ Add Medicine</button>

                <div class="form-group mt-3">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" rows="3"></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Create Prescription</button>
                    <a href="{{ route('prescriptions.index') }}" class="btn btn-secondary">Cancel</a>
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
    row.innerHTML = `
        <td><input type="text" class="form-control" name="items[${itemIndex}][medicine_name]" required></td>
        <td><input type="text" class="form-control" name="items[${itemIndex}][dosage]" required></td>
        <td><input type="text" class="form-control" name="items[${itemIndex}][frequency]" required></td>
        <td><input type="text" class="form-control" name="items[${itemIndex}][duration]" required></td>
        <td><input type="number" class="form-control" name="items[${itemIndex}][quantity]" required></td>
        <td><input type="text" class="form-control" name="items[${itemIndex}][instructions]"></td>
        <td><button type="button" class="btn btn-sm btn-danger remove-item">×</button></td>
    `;
    tbody.appendChild(row);
    itemIndex++;
    updateRemoveButtons();
});

document.getElementById('itemsBody').addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-item')) {
        e.target.closest('tr').remove();
        updateRemoveButtons();
    }
});

function updateRemoveButtons() {
    const rows = document.querySelectorAll('#itemsBody tr');
    rows.forEach((row, index) => {
        const btn = row.querySelector('.remove-item');
        btn.disabled = rows.length === 1;
    });
}
</script>
@endsection
