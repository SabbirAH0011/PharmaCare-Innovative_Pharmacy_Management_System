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
@if((!empty($name))&&(!empty($phone)))
<div class="col-md-12">
    <div class="row">
        <div class="col-lg-8 mb-4 order-0">
            <div class="card mb-4">
                <h5 class="card-header">Medicine list 🏪 (Details)</h5>
                <!-- Account -->
                <hr class="my-0">
                <div class="card-body">
                   @forelse($fetch_medicine as $medicine)
                <div class="col-md-12 col-xl-12 pt-5">


                    <div class="card">
                        <img class="card-img-top" src="{{ asset($medicine->main_image) }}" alt="Card image cap">
                        <div class="card-body">
                            <p class="card-img-bottom">
                                @if($medicine->total_stock > 0)
                                <span class="badge bg-label-success">In stock</span>
                                @else
                                <span class="badge bg-label-warning">Out of stock</span>
                                @endif
                            </p>
                            <form action="{{ route('update.medicine_list') }}" method="POST">
                                @csrf
                                <div class="mb-3">
                                    <label for="defaultInput" class="form-label">Medicine name</label>
                                    <input class="form-control" type="text" name="medicine_name" value="{{ $medicine->medicine_name }}">
                                    <input class="form-control" type="text" name="medicine_id" value="{{ $medicine->serial }}" hidden>
                                    @error('medicine_name')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="defaultInput" class="form-label">Type</label>
                                    <input class="form-control" type="text" name="medicine_type" value="{{ $medicine->medicine_type }}">
                                    @error('medicine_type')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="defaultInput" class="form-label"> Category: {{ $medicine->drug_category }} </label>
                                    <select name="drug_category" class="form-select">
                                        @forelse($fetch_drug_category as $drug_category)
                                        <option value="{{ $drug_category->category }}">{{ $drug_category->category }}</option>
                                        @empty
                                        <option>No Category is avaliable</option>
                                        @endif
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="defaultInput" class="form-label">Total Stock</label>
                                    <input class="form-control" type="text" name="total_stock" value="{{ $medicine->total_stock }}">
                                    @error('total_stock')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="defaultInput" class="form-label">Price</label>
                                    <input class="form-control" type="text" name="price" value="{{ $medicine->price }}">
                                    @error('price')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="input-group">
                                        <span class="input-group-text">Description</span>
                                        <textarea class="form-control" aria-label="With textarea" name="description"
                                            placeholder="Type Medicine Description">{{ $medicine->description }}</textarea>
                                    </div>
                                    @error('description')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="exampleDataList" class="form-label">Insert manufacturer</label>
                                    <input class="form-control" list="datalistManufaturar" id="manufacturer" name="manufacturer"
                                        placeholder="Type to search..." value="{{ $medicine->manufacturer }}">
                                    <datalist id="datalistManufaturar">
                                        @foreach($fetch_manufacturar as $manufacturar)
                                        <option value="{{ $manufacturar->name }}">
                                            @endforeach
                                    </datalist>
                                    @error('manufacturer')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <button class="btn btn-success d-grid w-100" type="submit">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>


                </div>
                    @empty
                    <div class="col-md-12 col-xl-12">
                        <div class="card bg-warning text-white mb-3">
                            <div class="card-body">
                                <h5 class="card-title text-white">No Medicine enlisted yet</h5>
                            </div>
                        </div>
                    </div>
                    @endforelse
                </div>
                {{ $fetch_medicine->withQueryString()->links() }}
                <!-- /Account -->
            </div>
        </div>
        <div class="col-12 col-md-8 col-lg-4 order-3 order-md-2">
            <div class="row">
                <div class="col-12 mb-4">
                    <div class="card">

                        <div class="card-body">
                            <div class="card-body">
                                <form action="{{ route('store.medicine_list') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <h4 class="text-light fw-semibold">Register Medicine 💊</h4>
                                    @if(session()->has('medicine_success'))
                                    <div class="alert alert-success alert-dismissible" role="alert">
                                        {{ session()->get('medicine_success') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @endif
                                    @error('medicine_error')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                        {{ $message }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"
                                            aria-label="Close"></button>
                                    </div>
                                    @enderror
                                    <div class="mb-3">
                                        <div class="holder">
                                            <img id="imgPreview" src="#" alt="pic" />
                                        </div>
                                        <label for="defaultInput" class="form-label">Upload medicine image</label>
                                        <input type="file" class="form-control" id="main_image" name="main_image">
                                        @error('main_image')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="defaultInput" class="form-label">Medicine name</label>
                                        <input class="form-control" type="text" name="medicine_name">
                                        <input class="form-control" type="text" name="store_id" value="{{ request()->store }}" hidden>
                                        @error('medicine_name')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="defaultInput" class="form-label">Type</label>
                                        <input class="form-control" type="text" name="medicine_type">
                                        @error('medicine_type')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="defaultInput" class="form-label">Select Category</label>
                                        <select name="drug_category" class="form-select">
                                            @forelse($fetch_drug_category as $drug_category)
                                            <option value="{{ $drug_category->category }}">{{ $drug_category->category }}</option>
                                            @empty
                                            <option>No Category is avaliable</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="defaultInput" class="form-label">Total Stock</label>
                                        <input class="form-control" type="text" name="total_stock">
                                        @error('total_stock')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                aria-label="Close"></button>
                                        </div>
                                        @enderror
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
                                        <div class="input-group">
                                            <span class="input-group-text">Description</span>
                                            <textarea class="form-control" aria-label="With textarea" name="description" placeholder="Type Medicine Description"></textarea>
                                        </div>
                                        @error('description')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <label for="exampleDataList" class="form-label">Insert manufacturer</label>
                                        <input class="form-control" list="datalistManufaturar" id="manufacturer" name ="manufacturer" placeholder="Type to search...">
                                        <datalist id="datalistManufaturar">
                                            @foreach($fetch_manufacturar as $manufacturar)
                                            <option value="{{ $manufacturar->name }}">
                                            @endforeach
                                        </datalist>
                                        @error('manufacturer')
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            {{ $message }}
                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="mb-3">
                                        <button class="btn btn-primary d-grid w-100" type="submit">Insert</button>
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
