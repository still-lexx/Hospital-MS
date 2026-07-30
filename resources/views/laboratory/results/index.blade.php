@extends('layouts.app')

@section('content')
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">Lab Results</h1>
            <nav class="flex-sm-00-auto ml-sm-3">
                <a href="{{ route('lab-results.create') }}" class="btn btn-primary">
                    <i class="fa fa-plus"></i> Add Result
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
                        <th>Date</th>
                        <th>Patient</th>
                        <th>Test</th>
                        <th>Result</th>
                        <th>Status</th>
                        <th>Performed By</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($results as $result)
                    <tr>
                        <td>{{ $result->result_date->format('M d, Y') }}</td>
                        <td>{{ $result->testRequest->patient->name }}</td>
                        <td>{{ $result->testRequest->labTest->name }}</td>
                        <td><strong>{{ $result->result_value }}</strong></td>
                        <td>
                            <span class="badge badge-{{ $result->status == 'normal' ? 'success' : ($result->status == 'abnormal' ? 'warning' : 'danger') }}">
                                {{ ucfirst($result->status) }}
                            </span>
                        </td>
                        <td>{{ $result->performedBy->name ?? 'N/A' }}</td>
                        <td class="text-center">
                            <a href="{{ route('lab-results.show', $result) }}" class="btn btn-sm btn-info">
                                <i class="fa fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">No results found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            {{ $results->links() }}
        </div>
    </div>
</div>
@endsection
