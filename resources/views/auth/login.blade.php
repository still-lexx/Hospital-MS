@extends('layouts.app')

@section('content')
                        <div class="row justify-content-center">
                            <div class="col-md-8 col-lg-6 col-xl-4">
                                <!-- Sign In Block -->
                                <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="block block-rounded block-themed mb-0">
                                    <div class="block-header bg-primary-dark">
                                        <h3 class="block-title">Sign In</h3>
                                        <div class="block-options">
                                        @if (Route::has('password.request'))
                                            <a class="btn-block-option font-size-sm" href="{{ route('password.request') }}">Forgot Password?</a>
                                        @endif
                                        
                                        </div>
                                    </div>
                                    <div class="block-content">
                                        <div class="p-sm-3 px-lg-4 py-lg-5">
                                            <h1 class="h2 mb-1">HMS</h1>
                                            <p class="text-muted">
                                                Welcome, please login.
                                            </p>

                                            <!-- Sign In Form -->
                                            <!-- jQuery Validation (.js-validation-signin class is initialized in js/pages/op_auth_signin.min.js which was auto compiled from _es6/pages/op_auth_signin.js) -->
                                            <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                                            <form class="js-validation-signin" action="be_pages_auth_all.html" method="POST">
                                                <div class="py-3">
                                                    <div class="form-group">
                                                        <input id="email" type="email" class="form-control form-control-alt form-control-lg @error('email') is-invalid @enderror" name="email" placeholder="Email Address">
                                                        @error('email')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    
                                                    <div class="form-group">
                                                        <input id="password" type="password" class="form-control form-control-alt form-control-lg @error('password') is-invalid @enderror"  name="password" placeholder="Password">
                                                        @error('password')
                                                            <span class="invalid-feedback" role="alert">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                        @enderror
                                                    </div>
                                                    <div class="form-group">
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                                            <label class="custom-control-label font-w400" for="login-remember">Remember Me</label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <div class="col-md-6 col-xl-5">
                                                        <button type="submit" class="btn btn-block btn-alt-primary">
                                                            <i class="fa fa-fw fa-sign-in-alt mr-1"></i> Sign In
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                            <!-- END Sign In Form -->
                                        </div>
                                    </div>
                                </div>
                                </form>
                                <!-- END Sign In Block -->
                            </div>
                        </div>

                    <div class="content content-full font-size-sm text-muted text-center">
                        <strong>OneUI 4.7</strong> &copy; <span data-toggle="year-copy"></span>
                    </div>
@endsection
