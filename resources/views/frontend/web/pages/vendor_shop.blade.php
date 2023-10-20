
@extends('frontend.web.layout.web-master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $store_name }}
                    <div class="d-flex justify-content-end">
                       Total item: {{ $total_count }}
                    </div>
                </h5>
                <p class="card-text">
                    {{ $address }}, Phone: {{ $phone }}
                </p>

            </div>
        </div>
    </div>

    <div class="col-12 pt-2">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-5">
                        @forelse($vendor_store as $store)
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
                        @empty
                        <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="800px" alt="Card image">
                        @endforelse

                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $vendor_store->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
