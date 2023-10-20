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

                    <div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Write your email and we will send you the otp</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Enter your email" autofocus />
                            <span class="text-danger" id="error_span"></span>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" id="send_otp">Sign in</button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /Register -->
        </div>
</div>
<script>
    var wait = '<i class="fas fa-spinner fa-pulse"></i> Please wait';
    $(document).ready(function () {
        $(document).on('click', '#send_otp', function (e) {
            e.preventDefault();
            $('#error_span').html('');
            const email = $('#email').val();
            var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
            if(!email){
                $('#error_span').html('Email can not be empty');
            }else if(testEmail.test(email)){
                $.ajax({
                    type: "GET",
                    url: "{{ route('get.otp_verify') }}",
                    data: { 'email': email },
                    dataType: "json",
                    beforeSend: function () {
                        $('#send_otp').attr("disabled", true);
                        $('#send_otp').html(wait);
                    },
                    success: function (response) {
                        $('#send_otp').attr("disabled", false);
                        $('#send_otp').html('Send OTP');
                        if (response.error == 'yes') {
                            $('#error_span').html(response.msg);
                        } else if (response.error == 'no') {
                            window.location.href = response.url;
                        } else {
                            $('#error_span').html('Something went wrong please contact with admin');
                        }
                    }
                });
            }else{
                $('#error_span').html('Given input is not an email address. Please write an email address');
            }
        });

        $(document).on('keypress', function (e) {
            if (e.which == 13) {
                $('#error_span').html('');
                const email = $('#email').val();
                var testEmail = /^[A-Z0-9._%+-]+@([A-Z0-9-]+\.)+[A-Z]{2,4}$/i;
                if (!email) {
                    $('#error_span').html('Email can not be empty');
                } else if (testEmail.test(email)) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('get.otp_verify') }}",
                        data: { 'email': email },
                        dataType: "json",
                        beforeSend: function () {
                            $('#send_otp').attr("disabled", true);
                            $('#send_otp').html(wait);
                        },
                        success: function (response) {
                            $('#send_otp').attr("disabled", false);
                            $('#send_otp').html('Send OTP');
                            if (response.error == 'yes') {
                                $('#error_span').html(response.msg);
                            } else if (response.error == 'no') {
                                window.location.href = response.url;
                            } else {
                                $('#error_span').html('Something went wrong please contact with admin');
                            }
                        }
                    });
                } else {
                    $('#error_span').html('Given input is not an email address. Please write an email address');
                }
            }
        });
    });
</script>
@endsection
