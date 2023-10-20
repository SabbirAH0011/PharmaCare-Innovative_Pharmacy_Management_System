
@extends('frontend.web.layout.web-master')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                @foreach($doctors as $dr)
                <div class="card mb-3">
                    <div class="row g-0">
                        <div class="col-md-4">
                            @if(!empty($dr->image))
                             <img src="{{ asset($dr->image) }}" class="card-img card-img-left" alt="{{ $dr->name }}">
                            @else
                            <h2 class="pt-5 pb-5 text-center card-img card-img-left text-primary">{{ \Illuminate\Support\Str::limit( $dr->name ,
                                1,$end='' ) }}</h2>
                            @endif
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title">{{ $dr->name }}</h5>
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
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="col-12 pt-2">
        <div class="col-lg-12 mb-4 order-0">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Book an appointment</h5>
                    <form action="{{ route('submit.doctor_appointment') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control" type="text" name="doctor" value="{{ request()->serial }}" hidden>
                            <label for="defaultInput" class="form-label">Patient Name</label>
                            <input class="form-control" type="text" name="patient_name">
                            @error('patient_name')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="defaultInput" class="form-label">Patient Ager</label>
                            <input class="form-control" type="number" name="patient_age">
                            @error('patient_age')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="defaultSelect" class="form-label">Select visiting day</label>
                            <select name="visiting_day" class="form-select">
                                @foreach($doctors as $dr)
                                @foreach(json_decode($dr->day,true) as $key=> $vd)
                                <option value="{{ $vd['day'] }}">{{ $vd['day'] }}</option>
                                @endforeach
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-primary d-grid w-100" id="send_otp">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
