@extends('frontend.web.layout.web-master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Set your location</h5>
            <!-- Account -->
            <hr class="my-0">
            <div class="card-body">
                @if(!empty(request()->required ))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ request()->required }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif
                <form action="{{ route('store.user_location') }}" method="GET">
                    <div class="mb-3">
                        <label for="defaultSelect" class="form-label">Select your location first</label>
                        <select name="location" class="form-select">
                            @forelse($fetch_zone as $location)
                            <option value="{{ $location->zone }}">{{ $location->zone }}</option>
                            @empty
                            <option>No Laction has been set yet</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Next</button>
                    </div>
                </form>
            </div>
            <!-- /Account -->
        </div>
    </div>
</div>
@endsection
