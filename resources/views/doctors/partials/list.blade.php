<div class="table-responsive">
    <table class="table table-bordered table-striped table-vcenter">
        <thead>
            <tr>
                <th>Name</th>
                <th>Specialization</th>
                <th>Phone</th>
                <th>Status</th>
                <th class="text-center" style="width: 100px;">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($doctors as $doctor)
                <tr>
                    <td class="font-w600">
                        <a href="{{ route('doctors.show', $doctor) }}">{{ $doctor->user->name ?? 'N/A' }}</a>
                    </td>
                    <td>
                        {{ $doctor->specialization }}
                    </td>
                    <td>
                        {{ $doctor->phone ?? 'N/A' }}
                    </td>
                    <td>
                        <span class="badge badge-{{ $doctor->is_available ? 'success' : 'danger' }}">
                            {{ $doctor->is_available ? 'Available' : 'Unavailable' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <div class="btn-group">
                            <a href="{{ route('doctors.show', $doctor) }}" class="btn btn-sm btn-primary" title="View">
                                <i class="fa fa-fw fa-eye"></i>
                            </a>
                            <a href="{{ route('doctors.edit', $doctor) }}" class="btn btn-sm btn-primary" title="Edit">
                                <i class="fa fa-fw fa-pencil-alt"></i>
                            </a>
                            <form action="{{ route('doctors.destroy', $doctor) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to remove this doctor profile?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-primary" title="Delete">
                                    <i class="fa fa-fw fa-times"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">
                        <p class="font-w600 mb-2">No doctors found.</p>
                        <a href="{{ route('doctors.create') }}" class="btn btn-sm btn-primary">Add First Doctor</a>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
<div class="mt-2">
    {{ $doctors->appends(request()->query())->links() }}
</div>
