@extends('frontend.web.layout.dashboard-master')
@section('content')
<div class="row">
    <!-- Center -->
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h2 class="card-title">Pay Via Card</h2>
                <form action="{{ route('submit_pay.check_via_online_card') }}" method="POST">
                    @csrf
                    @if(session()->has('payement_error'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ session()->get('payement_error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Card number</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="payment_token" value="{{ request()->payment_token }}" hidden>
                            <input class="form-control" type="number" name="card_number" placeholder="4242424242424242">
                            @error('card_number')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Year</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" name="year" placeholder="24">
                            @error('year')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Month</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" name="month" placeholder="02">
                            @error('month')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">CVC</label>
                        <div class="col-md-10">
                            <input class="form-control" type="number" name="cvc" placeholder="1234">
                            @error('cvc')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <button class="btn btn-primary">Make Payment</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
