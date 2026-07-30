@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Add OT Room</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <form action="{{ route('ot-rooms.store') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Room Number <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="room_number" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Room Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="room_name" required>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Status <span class="text-danger">*</span></label>
                            <select class="form-control" name="status" required>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Maintenance</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Capacity <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="capacity" value="1" min="1" required>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label>Equipment</label>
                    <textarea class="form-control" name="equipment" rows="3" placeholder="List available equipment..."></textarea>
                </div>

                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add OT Room</button>
                    <a href="{{ route('ot-rooms.index') }}" class="btn btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
