@extends('layouts.app')

@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Doctors <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Manage medical staff</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Doctors</li>
                    <li class="breadcrumb-item" aria-current="page">List</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <a href="{{ route('doctors.create') }}" class="btn btn-primary">
                <i class="fa fa-plus mr-1"></i> Add New Doctor
            </a>
        </div>
    </div>
    <!-- END Quick Actions -->

    <!-- Doctors Block -->
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">All Doctors</h3>
            <div class="block-options">
                <form action="{{ route('doctors.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-alt" id="search" name="search" placeholder="Search doctors..." value="{{ request('search') }}">
                        <div class="input-group-append">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="block-content block-content-full" id="doctors-list">
            @include('doctors.partials.list')
        </div>
    </div>
    <!-- END Doctors Block -->
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const doctorsList = document.getElementById('doctors-list');
        let timeout = null;

        searchInput.addEventListener('keyup', function() {
            clearTimeout(timeout);
            const query = this.value;

            timeout = setTimeout(function() {
                fetch(`{{ route('doctors.index') }}?search=${query}`, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                .then(response => response.text())
                .then(html => {
                    doctorsList.innerHTML = html;
                })
                .catch(error => console.error('Error:', error));
            }, 300); // Debounce for 300ms
        });
    });
</script>
@endsection
