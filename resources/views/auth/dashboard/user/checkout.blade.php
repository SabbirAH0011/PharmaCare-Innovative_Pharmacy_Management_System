@extends('frontend.web.layout.dashboard-master')
@section('content')
<div class="row">
    @if($validate_existance === true)
    <!-- Center -->
    <div class="col-12 col-md-8">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Product</h4>
                        <hr>
                        @foreach($get_total_product as $product)
                        <div class="card mb-3 shadow p-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset($product->main_image) }}" class="img-fluid rounded-start"
                                        alt="{{ $product->medicine_name }}">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->medicine_name }}</h5>
                                        <p class="card-text">{{ $product->bought }} X {{ $product->price }} BDT</p>
                                        <p class="card-text">Type: <span class="text-primary">{{ $product->medicine_type }}</span></p>
                                        <p class="card-text">Store name: <span class="text-primary">{{ $product->store_name }}</span></p>
                                        <p class="card-text">Location: <span class="text-primary">{{ $product->zone }}</span></p>
                                        @if($product->total_stock > 0)
                                        <span class="badge rounded-pill bg-primary">In Stock</span>
                                        @else
                                        <span class="badge rounded-pill bg-danger">Out Of Stock</span>
                                        @endif
                                        @if($product->total_stock >= $product->bought)
                                        <span class="badge rounded-pill bg-success">{{ $product->total_stock }} (Ready to buy)</span>
                                        @else
                                        <span class="badge rounded-pill bg-danger">{{ $product->total_stock }} (Less then total bought)</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Right -->
    <div class="col-12 col-md-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Grand Total</h4>
                        <hr>
                        <form action="{{ route('store.checkout_data') }}" method="POST">
                            @csrf
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <tr>
                                    <th>Grand Total</th>
                                    <td>
                                        {{ $grand_total }} BDT
                                        <input type="text" id="grand_total" value="{{ $grand_total }}" name ="grand_total" hidden>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Delivary Charge</th>
                                    <td>
                                        <span id="delivary_charge_readyonly">{{ $delivery_charge }}</span> BDT
                                        <input type="text" id="delivary_charge" value="{{ $delivery_charge }}" name ="delivery_charge" hidden>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 pt-3">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Shipping Address And Payment</h4>
                        <hr>

                                <div class="mb-3 row">
                                    <label for="shpping_address" class="col-md-4 col-form-label">Shipping Address</label>
                                    <div class="col-md-8">
                                        @if(!empty(request()->old('shpping_address')))
                                        <textarea class="form-control" type="text" rows="4" id="shpping_address"
                                        name="shpping_address">{{ request()->old('shpping_address') }}</textarea>
                                        @else
                                        <textarea class="form-control border border-primary" type="text" rows="4" id="shpping_address" name="shpping_address"></textarea>
                                        @endif
                                    @error('shpping_address')
                                    <span class="bg-danger text-white px-3">{{ $message }}</span>
                                    @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label for="payment_method" class="col-md-4 col-form-label">Payment Method</label>
                                    <div class="col-md-8">
                                        <div class="card shadow">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="radio" id="payment_method" name="payment_method" value="COD">
                                                    <label class="form-check-label" for="payment_method">💵 Cash On Delivery</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="pt-2">
                                            <div class="card shadow">
                                                <div class="card-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" id="payment_method" name="payment_method" value="OnlinePay">
                                                        <label class="form-check-label" for="payment_method">💳 Online payment</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @error('payment_method')
                                    <span class="bg-danger text-white px-3 text-center">{{ $message }}</span>
                                    @enderror
                                </div>
                               <div class="row mt-3">
                                   <div class="d-grid gap-2">
                                       <button class="btn btn-success btn-lg" type="Submit">Buy</button>
                                   </div>
                               </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="800px"
                    alt="Card image">
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
