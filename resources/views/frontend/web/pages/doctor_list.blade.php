
@extends('frontend.web.layout.web-master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Find your doctor
                    <div class="d-flex justify-content-end">
                       Total Registerd: {{ $total_count }}
                    </div>

                    <div class="pt-3">
                        <form action="{{ route('find-doctor') }}" method="GET">
                            <div class="row  border border-primary">
                                <div class="col-10 ">
                                    <input type="search" class="form-control border-0 shadow-none search" placeholder="Search..." name="doctor_search"
                                        aria-label="Search..." value="{{ request()->doctor_search }}" />
                                </div>
                                <div class="col-2 col-form-label" for="basic-default-name">
                                    <button type="submit" class="btn btn-success btn-sm"><i class="bx bx-search fs-4 lh-0"></i></button>
                                </div>
                            </div>
                        </form>
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
                        @forelse($doctors as $dr)
                        <div class="col-md-6 col-xl-4">
                                <div class="pt-2">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $dr->name }}</h5>
                                            <div class="text-center">
                                                @if(!empty($dr->image))
                                                <div style="align-items: center;">
                                                    <img src="{{ asset($dr->image) }}" class="img-thumbnail" width="150px" alt="{{ $dr->name }}">
                                                </div>
                                                @else
                                                <h2 class="pt-5 pb-5 text-center text-primary">{{ \Illuminate\Support\Str::limit( $dr->name , 1,$end='' ) }}</h2>
                                                @endif
                                            </div>

                                            <div class="card-text">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">{{ $dr->degree }}</li>
                                                    <li class="list-group-item">Specialist: {{ $dr->speciality }}</li>
                                                    <li class="list-group-item">Hospital: {{ $dr->hospital }}</li>
                                                    <li class="list-group-item">Visiting Hr: {{ $dr->time }}</li>
                                                    <li class="list-group-item">Visiting day:
                                                    @foreach(json_decode($dr->day,true) as $key=> $vd)
                                                        <span class="badge rounded-pill bg-info">{{ $vd['day'] }}</span>
                                                     @endforeach
                                                    </li>
                                                </ul>
                                            </div>
                                            <a href="{{ route('get.doctor_appointment', ['serial' => $dr->serial]) }}" class="btn btn-success">Get appointment</a>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        @empty
                        <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="800px" alt="Card image">
                        @endforelse

                    </div>
                </div>
                <div class="d-flex justify-content-center">
                    {{ $doctors->withQueryString()->links() }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
