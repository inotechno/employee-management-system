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
                                    <h5 class="text-primary"> Reset Password</h5>
                                </div>
                            </div>
                            <div class="col-5 align-self-end">
                                <img src="/images/profile-img.png" alt="" class="img-fluid">
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0"> 
                        <div>
                            <a href="#">
                                <div class="avatar-md profile-user-wid mb-4">
                                    <span class="avatar-title rounded-circle bg-light">
                                        <img src="/images/logo.svg" alt="" class="rounded-circle" height="34">
                                    </span>
                                </div>
                            </a>
                        </div>
                        
                        <div class="p-2">
                               
                            <form action="{{ route('forgot.password.post') }}" method="POST" class="needs-validation" novalidate>
                                    @csrf
                                    <div class="mb-3">
                                            <label for="email" class="form-label">Email address</label>
                                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter email" required autofocus>
                                           
                                            @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    {{ $message }}
                                                </span>
                                            @enderror
                                    </div>
                                <p>we'll send forget password link on your email.</p>
                                <div class="text-end">
                                    <button class="btn btn-primary w-md waves-effect waves-light" type="submit">Reset</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="mt-5 text-center">
                    <p>Remember It ? <a href="{{ route('login') }}" class="fw-medium text-primary"> Sign In here</a> </p>
                    <p>© <script>document.write(new Date().getFullYear())</script> {{ config('setting.app_name') }}</p>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
