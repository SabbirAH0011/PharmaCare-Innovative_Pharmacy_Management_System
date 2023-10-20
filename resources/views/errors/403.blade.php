@extends('frontend.web.layout.error-master')
@section('content')
<div class="container-xxl container-p-y">
    <div class="misc-wrapper">
        <h2 class="mb-2 mx-2">Forbidden(</h2>
        <p class="mb-4 mx-2">You are not allowed to access</p>
        <a href="{{ route('welcome') }}" class="btn btn-primary">Back to home</a>
    </div>
</div>
@endsection
