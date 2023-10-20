
@extends('frontend.web.layout.web-master')
@section('content')
    <style>
        .darkened-image {
            filter: brightness(50%);
        }
    </style>
<div class="row">
    @if(!empty(request()->success ))
    <div class="alert alert-success alert-dismissible" role="alert">
        {{ request()->success }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <div class="col-lg-8 mb-4 order-0">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#carouselExample" data-bs-slide-to="0" class=""></li>
                <li data-bs-target="#carouselExample" data-bs-slide-to="1" class=""></li>
                <li data-bs-target="#carouselExample" data-bs-slide-to="2" class="active" aria-current="true"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <div class="card">
                        <div class="card-body">
                            <img class="d-block w-25" src="{{ asset('assets/img/sites/slide1.jpg') }}" alt="First slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h3 class="text-primary">Pharma Check</h3>
                                <p class="text-primary">We are always here to help you</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="card">
                        <div class="card-body">
                            <img class="d-block w-25" src="{{ asset('assets/img/sites/ambulance.jpg') }}" alt="Second slide">
                            <div class="carousel-caption d-none d-md-block">
                                <h3 class="text-primary">Pharma Check Ambulance</h3>
                                <p class="text-primary">Book any time anywhere you need</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExample" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExample" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </a>
        </div>
    </div>
<div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
    <div class="row">
        <div class="col-12 mb-4">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-sm-7">
                        <div class="card-body">
                            <h5 class="card-title text-primary">Ambulance Service 🚑</h5>
                            <p class="mb-4">
                               Book Ambulance in emergancey
                            </p>
                            @if(session()->get('path') === 'Admin')

                            @else
                            <a href="{{ route('select.location_for_booking') }}" class="btn btn-sm btn-outline-primary">Book Now</a>
                            @endif

                        </div>
                    </div>
                    <div class="col-sm-5 text-center text-sm-left">
                        <div class="card-body pb-0 px-0 px-md-4">
                            <img src="{{ asset('assets/img/sites/ambulance.jpg') }}" height="100" alt="View Badge User"
                                data-app-dark-img="{{ asset('assets/img/sites/ambulance.jpg') }}"
                                data-app-light-img="{{ asset('assets/img/sites/ambulance.jpg') }}">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@if($verify_primary_care === true)
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Primary care</h4>
                <hr>
            </div>
            <div class="card-body">

                <div class="row mb-5">
                    @foreach($fetch_primary_care as $primary_care)
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ url('/product/details/'.$primary_care->serial ) }}">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $primary_care->medicine_name }}</h5>
                                    <p class="card-text text-dark">
                                        Type: <span class="text-success">{{ $primary_care->medicine_type}}</span>
                                    </p>
                                    <p class="card-text text-dark">
                                        Shop: {{ $primary_care->store_name}}
                                    </p>
                                    <p class="card-text text-dark">
                                        Location: {{ $primary_care->address}}
                                    </p>
                                    <p class="card-text">Price: {{ $primary_care->price }} BDT</p>
                                </div>
                                <img class="card-img-bottom" src="{{ asset($primary_care->main_image) }}" height="241px" width="300px" alt="Card image cap">
                            </div>
                        </a>
                    </div>
                    @endforeach
                    <div class="col-md-6 col-xl-4 pt-2">
                        <a href="{{ route('product.list',['category' => 'Primary-care' ]) }}">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class='bx bx-plus text-primary' style="font-size: 20rem;"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
@if($verify_mother_and_baby === true)
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Mother and Baby</h4>
                <hr>
            </div>
            <div class="card-body">

                <div class="row mb-5">
                    @foreach($fetch_mother_and_baby as $mother_and_baby)
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ url('/product/details/'.$mother_and_baby->serial ) }}">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $mother_and_baby->medicine_name }}</h5>
                                    <p class="card-text text-dark">
                                        Type: <span class="text-success">{{ $mother_and_baby->medicine_type}}</span>
                                    </p>
                                    <p class="card-text text-dark">
                                        Shop: {{ $mother_and_baby->store_name}}
                                    </p>
                                    <p class="card-text text-dark">
                                        Location: {{ $mother_and_baby->address}}
                                    </p>
                                    <p class="card-text">Price: {{ $mother_and_baby->price }} BDT</p>
                                </div>
                                <img class="card-img-bottom" src="{{ asset($mother_and_baby->main_image) }}" height="241px" width="300px" alt=" Card
                                    image cap">
                            </div>
                        </a>
                    </div>
                    @endforeach
                    <div class="col-md-6 col-xl-4 pt-2">
                        <a href="{{ route('product.list',['category' => 'Mother-and-baby' ]) }}">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class='bx bx-plus text-primary' style="font-size: 20rem;"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
@if($verify_supplements_and_vitamins === true)
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Mother and Baby</h4>
                <hr>
            </div>
            <div class="card-body">

                <div class="row mb-5">
                    @foreach($fetch_verify_supplements_and_vitamins as $supplements_and_vitamins)
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ url('/product/details/'.$supplements_and_vitamins->serial ) }}">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $supplements_and_vitamins->medicine_name }}</h5>
                                    <p class="card-text text-dark">
                                        Type: <span class="text-success">{{ $supplements_and_vitamins->medicine_type}}</span>
                                    </p>
                                    <p class="card-text text-dark">
                                        Shop: {{ $supplements_and_vitamins->store_name}}
                                    </p>
                                    <p class="card-text text-dark">
                                        Location: {{ $supplements_and_vitamins->address}}
                                    </p>
                                    <p class="card-text">Price: {{ $supplements_and_vitamins->price }} BDT</p>
                                </div>
                                <img class="card-img-bottom" src="{{ asset($supplements_and_vitamins->main_image) }}" height="241px" width="300px"
                                    alt=" Card
                                    image cap">
                            </div>
                        </a>
                    </div>
                    @endforeach
                    <div class="col-md-6 col-xl-4 pt-2">
                        <a href="{{ route('product.list',['category' => 'Supplements-and-vitamins' ]) }}">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class='bx bx-plus text-primary' style="font-size: 20rem;"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
@if($verify_personal_care === true)
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title text-center">Mother and Baby</h4>
                <hr>
            </div>
            <div class="card-body">

                <div class="row mb-5">
                    @foreach($fetch_personal_care as $personal_care)
                    <div class="col-md-6 col-xl-4">
                        <a href="{{ url('/product/details/'.$personal_care->serial ) }}">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title text-center">{{ $personal_care->medicine_name }}
                                    </h5>
                                    <p class="card-text text-dark">
                                        Type: <span class="text-success">{{
                                            $personal_care->medicine_type}}</span>
                                    </p>
                                    <p class="card-text text-dark">
                                        Shop: {{ $personal_care->store_name}}
                                    </p>
                                    <p class="card-text text-dark">
                                        Location: {{ $personal_care->address}}
                                    </p>
                                    <p class="card-text">Price: {{ $personal_care->price }} BDT</p>
                                </div>
                                <img class="card-img-bottom" src="{{ asset($personal_care->main_image) }}"
                                    height="241px" width="300px" alt=" Card
                                    image cap">
                            </div>
                        </a>
                    </div>
                    @endforeach
                    <div class="col-md-6 col-xl-4 pt-2">
                        <a href="{{ route('product.list',['category' => 'Personal-care' ]) }}">
                            <div class="card">
                                <div class="card-body text-center">
                                    <i class='bx bx-plus text-primary' style="font-size: 20rem;"></i>
                                </div>
                            </div>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
@if($verify_vendor_patner === true)
<div class="row">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card text-center">
          <div class="card-body bg-primary">
            <h4 class="card-title" style=" color:white">Our Pharmacy Partner</h4>
            <div class="row mb-5">
                @foreach($fetch_store as $store)
                <div class="col-md-6 col-xl-4">
                    <a href="{{ route('vendor.shop',['shop_id' => $store->serial ]) }}">
                        <div class="card bg-dark border-0 text-white">
                            <img class="card-img darkened-image" src="{{ asset('assets/img/sites/9650681_7815.jpg') }}" alt="Card image">
                            <div class="card-img-overlay">
                                <h5 class="card-title text-white">{{ $store->store_name }}</h5>
                                <p class="card-text">
                                    {{ $store->address }}
                                </p>
                                <p class="card-text"><i class='menu-icon tf-icons bx bx-location-plus'></i> {{ $store->zone }}</p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach

            </div>
        </div>
        <div class="card-footer bg-primary">
            <a href="{{ route('vendor.list') }}" class="btn btn-info  rounded-pill">Visit our online store</a>
        </div>
    </div>
</div>
@endif
@endsection
