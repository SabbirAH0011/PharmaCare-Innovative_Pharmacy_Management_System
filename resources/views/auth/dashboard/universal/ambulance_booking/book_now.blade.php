@extends('frontend.web.layout.dashboard-master')
@section('content')
<style>
    .StripeElement {
        box-sizing: border-box;
        height: 40px;
        padding: 10px 12px;
        border: 1px solid transparent;
        border-radius: 4px;
        background-color: white;
        box-shadow: 0 1px 3px 0 #e6ebf1;
        -webkit-transition: box-shadow 150ms ease;
        transition: box-shadow 150ms ease;
    }

    .StripeElement--focus {
        box-shadow: 0 1px 3px 0 #cfd7df;
    }

    .StripeElement--invalid {
        border-color: #fa755a;
    }

    .StripeElement--webkit-autofill {
        background-color: #fefde5 !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <form action="{{ route('submit.ambulance_booking') }}" class="card mb-4" method="POST">
            @csrf
            <h5 class="card-header">Ambulance Booking 🚑 (Form)</h5>
            @error('error')
            <div class="alert alert-danger alert-dismissible" role="alert">
                {{ $message }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @enderror
            <!-- Account -->
            <hr class="my-0">
            <div action="">
                <div class="card-body">
                    <div class="mb-3 row" hidden>
                        <label for="html5-text-input" class="col-md-2 col-form-label">Location</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" value="{{ request()->location }}" name="location">
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="html5-search-input" class="col-md-2 col-form-label">Select ambulance type</label>
                        <div class="col-md-10">
                            <select name="selected_ambulance" class="form-select">
                                @forelse($get_ambulance as $ambulance)
                                <option value="{{ $ambulance->serial }}">{{ $ambulance->type }} [{{ $ambulance->number_plate }}]</option>
                                @empty
                                <option>No Ambulance is avaliable</option>
                                @endif
                                </select>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Address</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text"  name="address" >
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <label for="html5-text-input" class="col-md-2 col-form-label">Destination</label>
                        <div class="col-md-10">
                            <input class="form-control" type="text" name="destination">
                        </div>
                    </div>
                <div class="mb-3 row">
                    <label for="html5-text-input" class="col-md-2 col-form-label">Card number</label>
                    <div class="col-md-10">
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
                    <button class="btn btn-primary">Pre-book now</button>
                </div>

                </div>
            </form>
            <!-- /Account -->
        </div>
    </form>
</div>
@endsection
