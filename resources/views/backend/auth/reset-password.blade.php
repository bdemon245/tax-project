@extends('backend.auth.layouts.app')

@section('content')
<div class="account-pages mt-5 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-4">
                <div class="card bg-pattern">

                    <div class="card-body p-4">

                        <div class="text-center w-75 m-auto">
                            <div class="auth-logo">
                                <a href="{{ route('login') }}" class="logo logo-dark text-center">
                                    <span class="logo-lg">
                                        <img loading="lazy" src="{{ asset('backend/assets/images/logo-dark.png') }}" alt=""
                                            height="22">
                                    </span>
                                </a>

                                <a href="{{ route('login') }}" class="logo logo-light text-center">
                                    <span class="logo-lg">
                                        <img loading="lazy" src="{{ asset('backend/assets/images/logo-light.png') }}" alt=""
                                            height="22">
                                    </span>
                                </a>
                            </div>
                            <p class="text-muted mb-4 mt-3">Reset your password.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Password Reset Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <div class="mb-3">
                                <label for="emailaddress" class="form-label">Email address</label>
                                <input
                                    class="form-control @error('email')
                                    is-invalid
                            @enderror"
                                    type="email" id="emailaddress" required="" placeholder="Enter your email" name="email" value="{{ $request->email }}">
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('email')
                                    is-invalid
                            @enderror"
                                        placeholder="Enter your password" name="password">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                    @error('password')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">Confrim Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password_confirmation')
                                    is-invalid
                            @enderror"
                                        placeholder="Enter your confirm password" name="password_confirmation">
                                    <div class="input-group-text" data-password="false">
                                        <span class="password-eye"></span>
                                    </div>
                                    @error('password_confirmation')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                                </div>
                            </div>


                            <div class="mb-3">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" id="checkbox-signin" checked>
                                    <label class="form-check-label" for="checkbox-signin">Remember me</label>
                                </div>
                            </div>

                            <div class="text-center d-grid">
                                <button class="btn btn-primary" type="submit"> Reset Password </button>
                            </div>

                        </form>

                    </div> <!-- end card-body -->
                </div>
                <!-- end card -->

            </div> <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->
@endsection