@extends('layouts.app')


@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Show User <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">View user details</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Show</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">User Information</h3>
        </div>
        <div class="block-content">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <div class="form-group">
                        <label><strong>{{ __('Name:') }}</strong></label>
                        <p class="form-control-static">{{ $user->name }}</p>
                    </div>

                    <div class="form-group">
                        <label><strong>{{ __('Email:') }}</strong></label>
                        <p class="form-control-static">{{ $user->email }}</p>
                    </div>

                    <div class="form-group">
                        <label><strong>{{ __('Roles:') }}</strong></label>
                        <div>
                            @if(!empty($user->getRoleNames()))
                                @foreach($user->getRoleNames() as $v)
                                    <span class="badge badge-success">{{ $v }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>

                    <div class="form-group">
                        <a href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
