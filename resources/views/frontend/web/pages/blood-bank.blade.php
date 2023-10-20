@extends('frontend.web.layout.web-master')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Blood Bank</h5>

            </div>
        </div>
    </div>

<div class="col-12 pt-2">
    <div class="col-lg-12 mb-4 order-0">
        <div class="card">
            <div class="card-body">

                <div class="row mb-5">
                    @forelse($fetch_blood_list as $blood)
                    <div class="col-md-6 col-xl-4">
                            <div class="pt-2">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="text-center bg-danger">
                                            <h2 class="pt-5 pb-5 text-center text-white">{{ $blood->group }}</h2>
                                        </div>

                                        <div class="card-text">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item">Bag reserved: {{ $blood->bag }}</li>
                                                @foreach(json_decode($blood->doners,true) as $key=> $donor)
                                                <li class="list-group-item">
                                                    Donor name: {{ $donor['donor_name'] }} <br>
                                                    Donor contact: {{ $donor['donor_contact'] }}
                                                </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                    @empty
                    <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}"
                        height="800px" alt="Card image">
                    @endforelse

                </div>
            </div>
            <div class="d-flex justify-content-center">
                {{ $fetch_blood_list->withQueryString()->links() }}
            </div>
        </div>

    </div>
</div>
</div>
@endsection
