@extends('frontend.web.layout.dashboard-master')
@section('content')
<div class="row">
    <div class="col-md-8 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Blood Bank</h5>
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Blood Group</th>
                                <th>Donor Details</th>
                                <th>Bag</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                @forelse($fetch_blood_list as $blood_list)
                <tr>
                    <td>{{ $blood_list->group }}</td>
                    <td>
                        <ul class="list-group pt-2">
                            @foreach(json_decode($blood_list->doners,true) as $key=> $donor)
                            <li class="list-group-item">
                                {{ $donor['donor_name'] }} <br>
                                {{ $donor['donor_contact'] }}
                            </li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $blood_list->bag }}</td>
                </tr>
                @empty
                <tr>
                    <td>
                        <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="800px"
                            alt="Card image">
                    </td>
                </tr>
                @endforelse
                {{ $fetch_blood_list->withQueryString()->links() }}
                </tbody>
                </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Register New Donor</h5>
                <form action="{{ route('bload.donation_store') }}" method="POST">
                @csrf
                    <div class="mb-3">
                        <label for="defaultInput" class="form-label">Blood Group</label>
                        <input class="form-control" type="text" name="blood_group" required>
                    </div>
                    <div class="mb-3">
                        <label for="defaultInput" class="form-label">Bag</label>
                        <input class="form-control" type="number" name="bag" required>
                    </div>
                    <div class="mb-3">
                        <label for="defaultInput" class="form-label">Donor name</label>
                        <input class="form-control" type="text" name="donor_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="defaultInput" class="form-label">Donor phone</label>
                        <input class="form-control" type="number" name="donor_contact" required>
                        @error('donor_contact')
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" type="submit">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
