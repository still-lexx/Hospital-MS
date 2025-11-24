@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-image" style="background-image: url('{{ asset('assets/media/photos/photo2@2x.jpg') }}');">
    <div class="bg-black-50">
        <div class="content content-full text-center">
            <div class="my-3">
                <img class="img-avatar img-avatar-thumb" src="{{ asset('assets/media/avatars/avatar10.jpg') }}" alt="">
            </div>
            <h1 class="h2 text-white mb-0">{{ $doctor->user->name ?? 'N/A' }}</h1>
            <span class="text-white-75">{{ $doctor->specialization }}</span>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="row">
        <div class="col-md-5 col-xl-4">
            <!-- Info Block -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">About</h3>
                    <div class="block-options">
                        <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-light">
                            <i class="fa fa-pencil-alt text-primary mr-1"></i> Edit
                        </a>
                    </div>
                </div>
                <div class="block-content">
                    <div class="font-size-sm mb-4">
                        <div class="font-w600 text-muted text-uppercase">Qualification</div>
                        <div>{{ $doctor->qualification ?? 'N/A' }}</div>
                    </div>
                    <div class="font-size-sm mb-4">
                        <div class="font-w600 text-muted text-uppercase">Experience</div>
                        <div>{{ $doctor->experience ? $doctor->experience . ' Years' : 'N/A' }}</div>
                    </div>
                    <div class="font-size-sm mb-4">
                        <div class="font-w600 text-muted text-uppercase">Contact</div>
                        <div><i class="fa fa-phone mr-1"></i> {{ $doctor->phone ?? 'N/A' }}</div>
                        <div><i class="fa fa-envelope mr-1"></i> {{ $doctor->user->email ?? 'N/A' }}</div>
                    </div>
                    <div class="font-size-sm mb-4">
                        <div class="font-w600 text-muted text-uppercase">Status</div>
                        <div>
                            <span class="badge badge-{{ $doctor->is_available ? 'success' : 'danger' }}">
                                {{ $doctor->is_available ? 'Available' : 'Unavailable' }}
                            </span>
                        </div>
                    </div>
                    @if($doctor->consultation_fee)
                    <div class="font-size-sm mb-4">
                        <div class="font-w600 text-muted text-uppercase">Consultation Fee</div>
                        <div>${{ number_format($doctor->consultation_fee, 2) }}</div>
                    </div>
                    @endif
                    @if($doctor->bio)
                    <div class="font-size-sm mb-4">
                        <div class="font-w600 text-muted text-uppercase">Bio</div>
                        <p>{{ $doctor->bio }}</p>
                    </div>
                    @endif
                </div>
            </div>
            <!-- END Info Block -->
        </div>
        <div class="col-md-7 col-xl-8">
            <!-- Recent Appointments Block -->
            <div class="block block-rounded">
                <div class="block-header block-header-default">
                    <h3 class="block-title">Recent Appointments</h3>
                </div>
                <div class="block-content block-content-full">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Patient</th>
                                    <th>Status</th>
                                    <th class="text-center" style="width: 100px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($doctor->appointments as $appointment)
                                    <tr>
                                        <td>
                                            <div class="font-w600">{{ $appointment->appointment_date->format('M d, Y') }}</div>
                                            <div class="font-size-sm text-muted">{{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }}</div>
                                        </td>
                                        <td>
                                            <a href="{{ route('patients.show', $appointment->patient) }}">{{ $appointment->patient->name }}</a>
                                        </td>
                                        <td>
                                            <span class="badge badge-{{ $appointment->status == 'confirmed' ? 'success' : ($appointment->status == 'cancelled' ? 'danger' : 'primary') }}">
                                                {{ ucfirst($appointment->status) }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('appointments.show', $appointment) }}" class="btn btn-sm btn-primary" title="View">
                                                <i class="fa fa-fw fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">
                                            <p class="font-w600 mb-2">No recent appointments.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!-- END Recent Appointments Block -->
        </div>
    </div>
</div>
@endsection
