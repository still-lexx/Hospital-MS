@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">OT Rooms</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('ot-rooms.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add OT Room
                </a>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-content">
            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th>Room Number</th>
                        <th>Room Name</th>
                        <th>Status</th>
                        <th>Capacity</th>
                        <th>Surgeries</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($otRooms as $room)
                    <tr>
                        <td>{{ $room->room_number }}</td>
                        <td>{{ $room->room_name }}</td>
                        <td>
                            <span class="badge badge-{{ $room->status == 'available' ? 'success' : ($room->status == 'occupied' ? 'warning' : 'secondary') }}">
                                {{ ucfirst($room->status) }}
                            </span>
                        </td>
                        <td>{{ $room->capacity }}</td>
                        <td>{{ $room->surgeries_count }}</td>
                        <td class="text-center">
                            <a href="{{ route('ot-rooms.edit', $room) }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No OT rooms found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $otRooms->links() }}
        </div>
    </div>
</div>
@endsection
