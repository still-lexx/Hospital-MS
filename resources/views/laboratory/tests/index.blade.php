@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Lab Tests</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('lab-tests.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add Lab Test
                </a>
            </nav>
        </div>
    </div>
</div>

<div class="content">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="block block-rounded">
        <div class="block-content">
            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Normal Range</th>
                        <th>Status</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tests as $test)
                    <tr>
                        <td>{{ $test->name }}</td>
                        <td>{{ $test->category ?? '-' }}</td>
                        <td>₦{{ number_format($test->price, 2) }}</td>
                        <td>{{ $test->normal_range ?? '-' }} {{ $test->unit }}</td>
                        <td>
                            <span class="badge badge-{{ $test->status == 'active' ? 'success' : 'secondary' }}">
                                {{ ucfirst($test->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('lab-tests.edit', $test) }}" class="btn btn-sm btn-warning">
                                <i class="fa fa-edit"></i>
                            </a>
                            <form action="{{ route('lab-tests.destroy', $test) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this test?')">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">No lab tests found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $tests->links() }}
        </div>
    </div>
</div>
@endsection
