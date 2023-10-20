
@extends('frontend.web.layout.web-master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Vendor store list
                    <div class="d-flex justify-content-end">
                       Total Registerd: {{ $total_count }}
                    </div>
                </h5>

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
                            <a href="{{ route('vendor.shop',['shop_id' => $store->serial ]) }}">
                                <div class="pt-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $store->store_name }}</h5>
                                            <div class="text-center bg-primary">
                                                <h2 class="pt-5 pb-5 text-center text-white">{{ \Illuminate\Support\Str::limit( $store->store_name , 1,$end='' ) }}</h2>
                                            </div>

                                            <div class="card-text">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">Address: {{ \Illuminate\Support\Str::limit($store->address, 20, $end='...') }}</li>
                                                    <li class="list-group-item">Zone: {{ $store->zone }}</li>
                                                </ul>
                                            </div>
                                            <a href="tel:{{ $store->phone }}" class="card-text"><small class="text-dark"> <i
                                                        class='menu-icon tf-icons bx bx-phone'></i> {{ $store->phone }}</small></a>
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
