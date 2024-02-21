@extends('layouts.auth.index')

@section('title')
    Reset Password
@endsection

@section('content')
    <div class="account-pages my-5 pt-sm-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card overflow-hidden">
                        <div class="bg-primary bg-soft">
                            <div class="row">
                                <div class="col-7">
                                    <div class="text-primary p-4">
                                        <h5 class="text-primary">Reset Password</h5>
                                        <p>Get your free {{ config('setting.app_name') }} account now.</p>
                                    </div>
                                </div>
                                <div class="col-5 align-self-end">
                                    <img src="/images/profile-img.png" alt="" class="img-fluid">
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0">
                            <div>
                                <a href="index.html">
                                    <div class="avatar-md profile-user-wid mb-4">
                                        <span class="avatar-title rounded-circle bg-light">
                                            <img src="/images/logo.svg" alt="" class="rounded-circle"
                                                height="34">
                                        </span>
                                    </div>
                                </a>
                            </div>
                            <div class="p-2">
                                <form action="{{ route('reset.password.post') }}" method="POST" class="needs-validation"
                                    novalidate>
                                    @csrf
                                    <input type="hidden" name="token" value="{{ $token }}">

                                    <div class="mb-3">
                                        <label for="email" class="form-label">E-Mail Address</label>
                                        <input type="text" class="form-control @error('email') is-invalid @enderror"
                                            name="email" id="email" placeholder="Enter email">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror

                                    </div>

                                    <div class="mb-3">
                                        <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" name="password"
                                                class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Enter password " aria-label="Password"
                                                aria-describedby="password-addon">
                                            <button class="btn btn-light " type="button" id="password-addon"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>

                                        @error('password')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="password_confirmation"
                                            class="col-md-4 col-form-label text-md-right">Confirm
                                            Password</label>
                                        <div class="input-group auth-pass-inputgroup">
                                            <input type="password" name="password_confirmation"
                                                class="form-control @error('password_confirmation') is-invalid @enderror"
                                                placeholder="Enter Password Confirm " aria-label="password_confirmation"
                                                aria-describedby="password-addon-confirmation">
                                            <button class="btn btn-light " type="button"
                                                id="password-addon-confirmation"><i
                                                    class="mdi mdi-eye-outline"></i></button>
                                        </div>

                                        @error('password_confirmation')
                                            <span class="invalid-feedback" role="alert">
                                                {{ $message }}
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="mt-4 d-grid">
                                        <button class="btn btn-primary waves-effect waves-light" type="submit">Reset
                                            Password</button>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>
                    <div class="mt-5 text-center">

                        <div>
                            <p>©
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> {{ config('setting.app_name') }}.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
