@extends('frontend.web.layout.dashboard-master')
@section('content')
<div class="row">
    @if($validate_existance === true)
    <!-- Center -->
    <div class="col-12 col-md-8">
        <div class="row">
            <div class="col-12">
                @if(session()->has('cart_success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>✔</strong> {{ session()->get('cart_success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title">Cart products</h4>
                         <hr>
                        @foreach($get_total_product as $product)
                        <div class="card mb-3 shadow p-3">
                            <div class="row g-0">
                                <div class="col-md-4">
                                    <img src="{{ asset($product->main_image) }}" class="img-fluid rounded-start" alt="{{ $product->medicine_name }}">
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
                                <div class="card-footer">
                                    <form action="{{ route('remove.item_cart') }}" method="GET">
                                        <input type="text" value="{{ $product->cart_serial }}" name="cart_serial" hidden>
                                        <button class="btn btn-warning btn-sm" onclick="alert('⚠ Are you sure to remove this item from cart?')">❌ Remove From
                                            cart</button>
                                    </form>
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
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Grand Total</h4>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <tr>
                            <th>Grand Total</th>
                            <td>{{ $grand_total }} BDT</td>
                        </tr>
                    </table>
                </div>
                <div class="row mt-3">
                    <div class="d-grid gap-2">
                        <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg" type="button">Procced to checkout</a>
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
