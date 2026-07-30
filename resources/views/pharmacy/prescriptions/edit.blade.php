@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Update Prescription Status/Notes</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('prescriptions.update', $prescription) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Patient</label>
                            <input type="text" class="form-control" value="{{ $prescription->patient->name }}" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Doctor</label>
                            <input type="text" class="form-control" value="{{ $prescription->doctor ? $prescription->doctor->name : 'N/A' }}" readonly disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Prescription Date</label>
                            <input type="text" class="form-control" value="{{ $prescription->prescription_date->format('Y-m-d') }}" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" required>
                                <option value="active" {{ old('status', $prescription->status) == 'active' ? 'selected' : '' }}>Active</option>
                                <option value="completed" {{ old('status', $prescription->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $prescription->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <h4 class="mt-4">Medicines (Read-Only)</h4>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Medicine Name</th>
                            <th>Dosage</th>
                            <th>Frequency</th>
                            <th>Duration</th>
                            <th>Quantity</th>
                            <th>Instructions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($prescription->items as $item)
                        <tr>
                            <td><input type="text" class="form-control" value="{{ $item->medicine_name }}" readonly disabled></td>
                            <td><input type="text" class="form-control" value="{{ $item->dosage }}" readonly disabled></td>
                            <td><input type="text" class="form-control" value="{{ $item->frequency }}" readonly disabled></td>
                            <td><input type="text" class="form-control" value="{{ $item->duration }}" readonly disabled></td>
                            <td><input type="number" class="form-control" value="{{ $item->quantity }}" readonly disabled></td>
                            <td><input type="text" class="form-control" value="{{ $item->instructions }}" readonly disabled></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="form-group mt-3">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" rows="3">{{ old('notes', $prescription->notes) }}</textarea>
                    @error('notes')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Prescription</button>
                    <a href="{{ route('prescriptions.show', $prescription) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
