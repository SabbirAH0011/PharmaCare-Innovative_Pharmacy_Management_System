@extends('frontend.web.layout.web-master')
@section('content')
<div class="authentication-wrapper authentication-basic container-p-y">
        <div class="authentication-inner">
            <!-- Register -->
            <div class="card">
                <div class="card-body">
                    <!-- Logo -->
                    <div class="app-brand justify-content-center">
                        <a href="{{ route('welcome') }}" class="app-brand-link gap-2">
                            <span class="app-brand-text demo text-body fw-bolder">{{ env('APP_NAME') }}</span>
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h4 class="mb-2">Welcome to {{ env('APP_NAME') }}! 👋</h4>
                    <p class="mb-4">Please sign-in to your account</p>

                    <form action="{{ route('otp.varify') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input type="email" class="form-control" id="email" name="email" value="{{ request()->email }}" hidden/>
                            <label for="email" class="form-label">We have send you an otp, write that correct otp here</label>
                            <input type="number" class="form-control text-center" id="otp" name="otp"
                                placeholder="Enter the otp" autofocus />
                            @error('otp')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                            @error('email')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                            @error('error')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" >Verify</button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Register -->
        </div>
</div>
@endsection
