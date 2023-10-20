@php
$user_email = Session::get('email');
$user_access_token = Session::get('access_token');
$get_user_details = DB::table('user_admin_employee_accesses')
->where([
['email','=',$user_email],
['access_token','=',$user_access_token],
])
->get();
foreach($get_user_details as $user){
$name = $user->name;
$phone = $user->phone;
$path = $user->path;
}
@endphp
@extends('frontend.web.layout.dashboard-master')
@section('content')
@if((!empty($name))&&(!empty($phone)))
<div class="col-md-12">
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card mb-4">
                <h5 class="card-header">Vendor Store 🏪 (Details)</h5>
                <!-- Account -->
                <hr class="my-0">
                <div class="card-body">
                    @forelse($fetch_store as $store)
                    <div class="row">
                        <div class="col-md-12 col-xl-12">
                            <div class="card  mb-3">
                                <div class="row g-0">
                                    <div class="col-md-2">
                                        <div class="pt-10">
                                            <div class="pt-5 text-center"
                                                style="border-radius: 50%; padding: 25px;border: 2px solid rgb(97, 97, 97);border-style: dashed;">

                                                <h2 class="text-center text-dark">{{ \Illuminate\Support\Str::limit( $store->store_name , 1,$end='' ) }}</h2>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $store->store_name }}</h5>
                                            <div class="card-text">
                                                <ul class="list-group list-group-flush">
                                                    <li class="list-group-item">Address: {{ $store->address }}</li>
                                                    <li class="list-group-item">Zone: {{ $store->zone }}</li>
                                                    @if($store->status === 'Approved')
                                                    <li class="list-group-item">Store status: <span class="badge rounded-pill bg-success">{{
                                                            $store->status }}</span></li>
                                                    @else
                                                    <li class="list-group-item">Store status: <span class="badge rounded-pill bg-warning">{{ $store->status }}</span></li>
                                                    @endif
                                                </ul>
                                            </div>
                                            <a href="tel:{{ $store->phone }}" class="card-text"><small class="text-dark"> <i class='menu-icon tf-icons bx bx-phone'></i> {{ $store->phone }}</small></a>

                                    @if($store->status === 'Approved')
                                        <div class="demo-inline-spacing">
                                            <button type="button" class="btn btn-warning">Update</button>
                                            <a href="{{ route('list.medicine',['store'=> $store->serial ]) }}" type="button" class="btn btn-primary">List medicine</a>
                                        </div>
                                    @else
                                    <div class="demo-inline-spacing">
                                        <button type="button" class="btn btn-warning">Update</button>
                                        <button type="button" class="btn btn-primary" disabled>List medicine</button>
                                    </div>
                                    @endif
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
                                <h5 class="card-title text-white">No Store avaliable</h5>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
                {{ $fetch_store->withQueryString()->links() }}
                <!-- /Account -->
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card">

                        <div class="card-body">
                            <div class="card-body">
                                <form action="{{ route('register.store') }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <h4 class="text-light fw-semibold">Register Vendor Store 🏪</h4>
                                    @if(session()->has('store_success'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        {{ session()->get('store_success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif
                                    @error('store_error')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @enderror
                                    <div class="mb-3">
                                        <label for="defaultInput" class="form-label">Shope name</label>
                                        <input class="form-control" type="text" name="shope_name">
                                        @error('shope_name')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <div class="input-group">
                                            <span class="input-group-text">Shop addreess</span>
                                            <textarea class="form-control" aria-label="With textarea" name="shop_address"></textarea>
                                        </div>
                                        @error('shop_address')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="defaultInput" class="form-label">Phone</label>
                                        <input class="form-control" type="number" name="phone">
                                        @error('phone')
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
                                        <button class="btn btn-primary d-grid w-100" type="submit">Register</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@else
<div class="col-md-12">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body bg-warning text-white">
                    <h1 class="text-white text-center">
                        <i class='menu-icon tf-icons bx bx-lock-alt' style=" font-size: 100px;"></i> Please update your account information first
                    </h1>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
