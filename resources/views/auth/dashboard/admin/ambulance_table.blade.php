@extends('frontend.web.layout.dashboard-master')
@section('content')
<style>
    .holder {
        height: 300px;
        width: 300px;
        border: 2px solid black;
    }

    img {
        max-width: 300px;
        max-height: 300px;
        min-width: 300px;
        min-height: 300px;
    }

    input[type="file"] {
        margin-top: 5px;
    }

    .heading {
        font-family: Montserrat;
        font-size: 45px;
        color: green;
    }
</style>
<div class="row">
    <div class="col-lg-8 mb-4 order-0">
       <div class="card">
        <div class="card-body">
<div class="row">
    @forelse($get_ambulance as $ambulance)
    <div class="col-md-12 col-xl-12">
    <div class="card mb-3">
        <div class="row g-0">
            <div class="col-md-4">
                <img class="card-img card-img-left" src="{{ asset($ambulance->image) }}" alt="Card image">
            </div>
            <div class="col-md-8">
                <div class="card-body ">
                    <h5 class="card-title">{{ $ambulance->type }} <br>
                        <small class="text-muted">{{ $ambulance->serial }}</small>
                    </h5>
                    <div class="card-text">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item">Plate No: {{ $ambulance->number_plate }}</li>
                            <li class="list-group-item">Zone: {{ $ambulance->zone }}</li>
                            <li class="list-group-item">Price: {{ $ambulance->price }}</li>
                            <li class="list-group-item">Driver name: {{ $ambulance->name }}</li>
                            <li class="list-group-item">Driver contact: {{ $ambulance->phone }}</li>
                            @if($ambulance->status === 'Open')
                            <li class="list-group-item">Vehicle booking status: <span class="badge rounded-pill bg-success">{{ $ambulance->status }}</span></li>
                            @else
                            <li class="list-group-item">Vehicle booking status: <span class="badge rounded-pill bg-warning">Booked</span></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    @empty
    <div class="col-md-12 col-xl-12">
        <div class="card bg-warning text-white mb-3">
            <div class="card-body">
                <h5 class="card-title text-white">No Ambulance avaliable</h5>
            </div>
        </div>
    </div>
    @endforelse
</div>

{{ $get_ambulance->withQueryString()->links() }}

        </div>
       </div>
    </div>
    <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
        <div class="row">
            <div class="col-12 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-body">
                            <form action="{{ route('store.admbulance_booking') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <h4 class="text-light fw-semibold">Register an ambulance for service</h4>
                                @if(session()->has('success'))
                                <div class="alert alert-success alert-dismissible" role="alert">
                                    {{ session()->get('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                @error('error')
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @enderror
                                <div class="mb-3">
                                    <div class="holder">
                                        <img id="imgPreview" src="#" alt="pic" />
                                    </div>
                                    <label for="defaultInput" class="form-label">Upload vehicle image</label>
                                    <input type="file" class="form-control" id="main_image" name="main_image">
                                    @error('main_image')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="defaultInput" class="form-label">Number Plate</label>
                                    <input class="form-control" type="text" name="number_plate">
                                    @error('number_plate')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="defaultInput" class="form-label">Type</label>
                                    <input class="form-control" type="text" name="ambulance_type">
                                    @error('ambulance_type')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="defaultSelect" class="form-label">Zone</label>
                                    <select name="zone" class="form-select">
                                        @forelse($fetch_zone as $location)
                                        <option value="{{ $location->zone }}">{{ $location->zone }}</option>
                                        @empty
                                        <option>Registered zone is empty</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="defaultSelect" class="form-label">Driver</label>
                                    <select name="driver" class="form-select">
                                        @forelse($fetch_driver as $driver)
                                        <option value="{{ $driver->serial }}">{{ $driver->name }}</option>
                                        @empty
                                        <option>Registered zone is empty</option>
                                        @endforelse
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="defaultInput" class="form-label">Price</label>
                                    <input class="form-control" type="text" name="price">
                                    @error('price')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-primary d-grid w-100" id="send_otp">Sign in</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(() => {
    $('#main_image').change(function () {
        const file = this.files[0];
        console.log(file);
        if (file) {
            let reader = new FileReader();
            reader.onload = function (event) {
                console.log(event.target.result);
                $('#imgPreview').attr('src', event.target.result);
            }
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endsection
