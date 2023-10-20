@extends('frontend.web.layout.error-master')
@section('content')
<div class="container-xxl container-p-y">
    <div class="card">
        <div class="card-body">
            <div class="misc-wrapper">
                <div class="text-center">
                    <h2 class="mb-2 mx-2">No Content</h2>
                    <h4 class="mb-4 mx-2">
                        The item that you are looking for is not avaiable in your area <br>
                        Select your location and search for medicine
                    </h4>
                </div>
                <a href="{{ route('welcome') }}" class="btn btn-primary">Back to home</a>
            </div>
        </div>
    </div>
</div>
@endsection
