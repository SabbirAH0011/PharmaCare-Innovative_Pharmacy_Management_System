
@extends('frontend.web.layout.web-master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Showing medicine on {{ request()->name }}
                    <div class="d-flex justify-content-end">
                       Total found item: {{ $total_count }}
                    </div>
                </h5>
                <p class="card-text">
                    {{ request()->category }}
                </p>
                <div class="scrolling-wrapper">
                    @forelse($fetch_manufacturer as $manufacturere)
                    <a href="{{ route('product.list',[ 'name'=> $manufacturere->name ]) }}" class="manufacturer_tag"><span class="badge bg-primary">{{
                            $manufacturere->name }}</span></a>
                    @empty
                    <span class="badge bg-warning">Not avaliable</span>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 pt-2">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-body">

                    <div class="row mb-5">
                        @forelse($fetch_product as $product)
                        <div class="col-md-6 col-xl-4 pt-2">
                            <a href="{{ url('/product/details/'.$product->serial ) }}">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title">{{ $product->medicine_name }}</h5>
                                        <h6 class="card-subtitle text-muted">Type: <span class="text-success">{{
                                            $product->medicine_type}}</span></h6>
                                        <img class="img-fluid d-flex mx-auto my-4 border border-primary" src="{{ asset($product->main_image) }}" alt="{{ $product->medicine_name }}">
                                        <p class="card-text">Shop: {{ $product->store_name}}</p>
                                        <p class="card-text text-dark">Location: {{ \Illuminate\Support\Str::limit($product->address, 20, $end='...') }}</p>
                                        <p class="card-text">Price: {{ $product->price }} BDT</p>
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
                    {{ $fetch_product->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
