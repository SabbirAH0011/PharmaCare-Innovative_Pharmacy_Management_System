@php
foreach ($fetch_product_details as $product_details) {
$store_id = $product_details->store_id;
}
@endphp
@extends('frontend.web.layout.web-master')
@section('content')
<div class="row">
    <!-- Center -->
    <div class="col-12 col-md-8">
        <div class="row">
            <div class="col-12">
                @forelse($fetch_product_details as $details)
                <div class="card">
                    <div class="card-header">
                        <h4>{{ $details->medicine_name }}</h4>
                    </div>
                    <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-md-6">
                            <img class="img-thumbnail border border-primary rounded" src="{{ asset($details->main_image) }}">
                        </div>
                        <div class="col-12 col-md-6">
                            <p>
                                Type: <span class="text-primary">{{
                                    $details->medicine_type}}</span>
                            </p>
                            <p>
                                Manufacturer: <span class="text-primary">{{
                                    $details->manufacturer}}</span>
                            </p>
                            <p>
                                Shop: <span class="text-primary">{{
                                    $details->store_name}}</span>
                            </p>

                            <div class="center">
                                <input type="number" id="product_stock" value="{{ $details->total_stock }}" hidden>
                                <div class="input-group">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-danger btn-number minus" data-type="minus">
                                            -
                                        </button>
                                    </span>
                                    <input type="text" class="form-control input-number text-center" id="store_bought" name="store_bought" value="0" min="1">
                                    <span class="input-group-btn">
                                        <button type="button" class="btn btn-success btn-number plus" data-type="plus">
                                            +
                                        </button>
                                    </span>

                                </div>
                                <p class="text-center">Total stock: {{ $details->total_stock }} pcs</p>
                            </div>
                            @if(!empty(session()->get('email')))
                            @if(session()->get('path') === 'User')
                            <input type="text" value="{{ request()->producr_id }}" id="product_id" hidden>
                            <button class="btn btn-success" id="add_to_cart"><i class='menu-icon tf-icons bx bx-cart'></i> Add to cart</button>
                            @else
                            <button class="btn btn-success disabled">Add to cart</button>
                            @endif
                            @else
                            <a href="{{ route('get.otp') }}" type="button" class="btn btn-xs btn-primary">Log in</a>
                            @endif

                        </div>

                        <div class="col-12 pt-2">
                            <div class="nav-align-top mb-4">
                                <ul class="nav nav-pills mb-3" role="tablist">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
                                            Description
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div class="tab-pane fade active show" id="navs-pills-top-home" role="tabpanel">
                                        <p>
                                            {{ $details->description }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    </div>
                </div>
                @empty
                <div class="card">
                    <div class="card-body">
                        <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="800px"
                            alt="Card image">
                    </div>
                </div>
                @endforelse
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-12">
                        <div class="card bg-primary">
                            <div class="card-body text-white">

                                    <h4 class="card-title text-white">Vendor Store</h4>
                                    <hr>
                                    <div class="row mb-5">
                                        @foreach($vendor_store as $store)
                                        <div class="col-md-6 col-xl-4">
                                            <a href="{{ url('/product/details/'.$store->serial ) }}">
                                            <div class="pt-2">
                                                <div class="card">
                                                    <div class="card-body">
                                                        <h5 class="card-title">{{ $store->medicine_name }}</h5>
                                                        <h6 class="card-subtitle text-muted">Type: <span class="text-success">{{
                                                                $store->medicine_type}}</span></h6>
                                                        <img class="img-fluid d-flex mx-auto my-4 border border-primary" src="{{ asset($store->main_image) }}"
                                                            alt="{{ $store->medicine_name }}">
                                                        <p class="card-text">Shop: {{ $store->store_name}}</p>
                                                        <p class="card-text text-dark">Location: {{ \Illuminate\Support\Str::limit($store->address, 20,
                                                            $end='...') }}
                                                        </p>
                                                        <p class="card-text">Price: {{ $store->price }} BDT</p>
                                                    </div>
                                                </div>
                                            </div>
                                            </a>
                                        </div>
                                        @endforeach
                                        <div class="col-md-6 col-xl-4 pt-4">
                                            <a href="{{ route('vendor.shop',['shop_id' => $store_id ]) }}">
                                                <div class="card">
                                                    <div class="card-body text-center">
                                                        <i class='bx bx-plus text-primary' style="font-size: 15rem;"></i>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>



                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Right -->
    <div class="col-12 col-md-4">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title text-center">More Product</h5>
                @forelse($all_product as $product)
                <div class="col pt-2">
                    <a href="{{ url('/product/details/'.$product->serial ) }}">
                        <div class="pt-2">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $product->medicine_name }}</h5>
                                    <h6 class="card-subtitle text-muted">Type: <span class="text-success">{{
                                            $product->medicine_type}}</span></h6>
                                    <img class="img-fluid d-flex mx-auto my-4 border border-primary" src="{{ asset($product->main_image) }}"
                                        alt="{{ $product->medicine_name }}">
                                    <p class="card-text">Shop: {{ $product->store_name}}</p>
                                    <p class="card-text text-dark">Location: {{ \Illuminate\Support\Str::limit($product->address, 20, $end='...') }}
                                    </p>
                                    <p class="card-text">Price: {{ $product->price }} BDT</p>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                @empty
                <div class="card">
                    <div class="card-body">
                        <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="800px"
                            alt="Card image">
                    </div>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<script>
var wait = '<i class="fas fa-spinner fa-pulse"></i> Please wait';
$(document).ready(function () {
        $('.minus').click(function () {
           let store_bought = $('#store_bought').val();
            const stock = $('#product_stock').val();
            if ( parseInt(store_bought)  > 0) {
                let new_store = $('#store_bought').get(0).value--
            } else {
                let new_store = 0
            }
        });
        $('.plus').click(function () {
            let store_bought = $('#store_bought').val();
            const stock = $('#product_stock').val();
            if(parseInt(store_bought) <  parseInt(stock)){
                let new_store = $('#store_bought').get(0).value++
            }else{
                let new_store = $('#store_bought').val()
            }
        });
         $("#store_bought").blur(function () {
            let store_bought = $('#store_bought').val();
            const stock = $('#product_stock').val();
             if (parseInt(store_bought) < parseInt(stock)) {
                 let new_store = $('#store_bought').get(0).value++
                  $('#store_bought').val(new_store)
             } else {
                 let new_store = $('#product_stock').val()
                 $('#store_bought').val(new_store)
             }

         });
         /* Add to cart */
         $('#add_to_cart').click(function(e){
            e.preventDefault();
            const product_id = $('#product_id').val();
            const store_bought = $('#store_bought').val();
             $.ajaxSetup({
                 headers: {
                     'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                 }
             });
             $.ajax({
                 type: "POST",
                 url: "{{ route('store.add_to_cart_item') }}",
                 data: { 'product_id': product_id, 'store_bought' : store_bought },
                 dataType: "json",
                 beforeSend: function () {
                     $('#add_to_cart').attr("disabled", true);
                     $('#add_to_cart').html(wait);
                 },
                 success: function (response) {
                    alert(response.msg);
                    $('#add_to_cart').attr("disabled", false);
                    $('#add_to_cart').html('<i class="menu - icon tf - icons bx bx - cart"></i> Add to cart');
                    location.reload();
                 },
                 error: function (XMLHttpRequest, textStatus, errorThrown) {
                     alert(XMLHttpRequest.responseJSON.msg);
                     $('#add_to_cart').attr("disabled", false);
                     $('#add_to_cart').html('<i class="menu - icon tf - icons bx bx - cart"></i> Add to cart');
                 }
             });
         });
    });
</script>
@endsection
