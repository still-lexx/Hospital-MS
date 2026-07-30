@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <h1 class="h3 my-2">Surgery Details</h1>
    </div>
</div>

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Surgery Information</h3>
        </div>
        <div class="block-content">
            <div class="row">
                <div class="col-md-6">
                    <p><strong>Patient:</strong> {{ $surgery->patient->name }}</p>
                    <p><strong>Surgery:</strong> {{ $surgery->surgery_name }}</p>
                    <p><strong>Surgeon:</strong> {{ $surgery->doctor->name }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Date:</strong> {{ $surgery->surgery_date->format('M d, Y') }}</p>
                    <p><strong>OT Room:</strong> {{ $surgery->otRoom->room_name ?? 'Not assigned' }}</p>
                    <p><strong>Type:</strong> <span class="badge badge-{{ $surgery->type == 'emergency' ? 'danger' : 'info' }}">{{ ucfirst($surgery->type) }}</span></p>
                    <p><strong>Status:</strong> <span class="badge badge-{{ $surgery->status == 'completed' ? 'success' : ($surgery->status == 'in-progress' ? 'warning' : 'secondary') }}">{{ ucfirst($surgery->status) }}</span></p>
                </div>
            </div>
            @if($surgery->start_time)
            <p><strong>Start Time:</strong> {{ $surgery->start_time }}</p>
            @endif
            @if($surgery->end_time)
            <p><strong>End Time:</strong> {{ $surgery->end_time }}</p>
            @endif
            @if($surgery->notes)
            <p><strong>Notes:</strong> {{ $surgery->notes }}</p>
            @endif
        </div>
    </div>

    @if($surgery->team->count() > 0)
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Surgery Team</h3>
        </div>
        <div class="block-content">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Team Member</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($surgery->team as $member)
                    <tr>
                        <td>{{ $member->user->name }}</td>
                        <td>{{ ucfirst($member->role) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection
