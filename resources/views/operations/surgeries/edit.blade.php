@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Update Surgery Status/Details</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('surgeries.update', $surgery) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Patient</label>
                            <input type="text" class="form-control" value="{{ $surgery->patient->name }}" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Surgeon</label>
                            <input type="text" class="form-control" value="{{ $surgery->doctor->name }}" readonly disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Surgery Name</label>
                            <input type="text" class="form-control" value="{{ $surgery->surgery_name }}" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>OT Room</label>
                            <input type="text" class="form-control" value="{{ $surgery->otRoom ? $surgery->otRoom->room_name . ' (' . $surgery->otRoom->room_number . ')' : 'N/A' }}" readonly disabled>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" required>
                                <option value="scheduled" {{ old('status', $surgery->status) == 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                                <option value="in-progress" {{ old('status', $surgery->status) == 'in-progress' ? 'selected' : '' }}>In Progress</option>
                                <option value="completed" {{ old('status', $surgery->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                                <option value="cancelled" {{ old('status', $surgery->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Surgery Date</label>
                            <input type="text" class="form-control" value="{{ $surgery->surgery_date }}" readonly disabled>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>Start Time</label>
                            <input type="time" class="form-control" name="start_time" value="{{ old('start_time', $surgery->start_time) }}">
                            @error('start_time')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group">
                            <label>End Time</label>
                            <input type="time" class="form-control" name="end_time" value="{{ old('end_time', $surgery->end_time) }}">
                            @error('end_time')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Notes</label>
                    <textarea class="form-control" name="notes" rows="3">{{ old('notes', $surgery->notes) }}</textarea>
                    @error('notes')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Update Surgery</button>
                    <a href="{{ route('surgeries.show', $surgery) }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
