@extends('layouts.app')


@section('content')
<!-- Hero -->
<div class="bg-body-light">
    <div class="content content-full">
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <h1 class="flex-sm-fill h3 my-2">
                Hospital Profile <small class="d-block d-sm-inline-block mt-2 mt-sm-0 font-size-base font-w400 text-muted">Manage hospital settings</small>
            </h1>
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb breadcrumb-alt">
                    <li class="breadcrumb-item">Hospital</li>
                    <li class="breadcrumb-item active" aria-current="page">Profile</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<!-- END Hero -->

<div class="content">
    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Edit Profile</h3>
        </div>
        <div class="block-content">
            <div class="row justify-content-center">
                <div class="col-md-10 col-lg-8">
                    <form method="POST" action="{{ route('hospital.update') }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">{{ __('Hospital Name') }}</label>
                            <input id="name" type="text" class="form-control form-control-alt @error('name') is-invalid @enderror" name="name" value="{{ old('name', $hospital->name ?? '') }}" required autocomplete="name" autofocus>
                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="address">{{ __('Address') }}</label>
                            <input id="address" type="text" class="form-control form-control-alt @error('address') is-invalid @enderror" name="address" value="{{ old('address', $hospital->address ?? '') }}" autocomplete="address">
                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="phone">{{ __('Phone') }}</label>
                            <input id="phone" type="text" class="form-control form-control-alt @error('phone') is-invalid @enderror" name="phone" value="{{ old('phone', $hospital->phone ?? '') }}" autocomplete="phone">
                            @error('phone')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="email">{{ __('Email') }}</label>
                            <input id="email" type="email" class="form-control form-control-alt @error('email') is-invalid @enderror" name="email" value="{{ old('email', $hospital->email ?? '') }}" autocomplete="email">
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="logo">{{ __('Logo') }}</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo" name="logo">
                                <label class="custom-file-label" for="logo">Choose file</label>
                            </div>
                            @if(isset($hospital->logo))
                                <div class="mt-2">
                                    <img src="{{ asset('images/'.$hospital->logo) }}" alt="Hospital Logo" width="100" class="img-thumbnail">
                                </div>
                            @endif
                            @error('logo')
                                <div class="text-danger mt-1">
                                    <small><strong>{{ $message }}</strong></small>
                                </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="footer_text">{{ __('Footer Text') }}</label>
                            <input id="footer_text" type="text" class="form-control form-control-alt @error('footer_text') is-invalid @enderror" name="footer_text" value="{{ old('footer_text', $hospital->footer_text ?? '') }}" autocomplete="footer_text">
                            @error('footer_text')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Update Profile') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
