@extends('frontend.web.layout.dashboard-master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Profile Details</h5>
            <!-- Account -->
            <hr class="my-0">
            <div class="card-body">
                <form action="{{ route('store.account_details') }}" method="POST">
                    @csrf
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
                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="firstName" class="form-label">Name</label>
                            <input class="form-control" type="text" id="name" name="name" value="{{ $name }}"
                                autofocus="">
                            @error('name')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="lastName" class="form-label">Phone</label>
                            <input class="form-control" type="number" name="phone" id="phone" value="{{ $phone }}">
                            @error('phone')
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                {{ $message }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                            @enderror
                        </div>
                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">Save changes</button>
                        <button type="reset" class="btn btn-outline-secondary">Clear Form</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
</div>
@endsection
