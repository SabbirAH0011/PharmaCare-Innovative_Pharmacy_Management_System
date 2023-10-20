@extends('frontend.web.layout.dashboard-master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">User table 👨🏻</h5>
            <!-- Account -->
            <hr class="my-0">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Path</th>
                                <th>Status</th>
                                <th>Change Path</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($get_user_details as $user)
                            <tr>
                                <td>{{ $user->serial }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->path }}</td>
                                <td>{{ $user->status }}</td>
                                <form action="{{ route('change.user_status') }}" method="POST">
                                    @csrf
                                    <td>
                                        <div class="col-md">
                                            <input type="text" value="{{ $user->serial }}" id="serial" name="serial" hidden>
                                            @if($user->path === 'Ambulance-driver')
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" id="change_path"
                                                    name="change_path" value="Ambulance-driver" checked>
                                                <label class="form-check-label" for="change_path">Ambulance-driver</label>
                                            </div>
                                            @else
                                            <div class="form-check form-check-inline mt-3">
                                                <input class="form-check-input" type="radio" id="change_path"
                                                    name="change_path" value="Ambulance-driver">
                                                <label class="form-check-label" for="change_path">Ambulance-driver</label>
                                            </div>
                                            @endif
                                            @if($user->path === 'Rider')
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="change_path"
                                                    name="change_path" value="Rider" checked>
                                                <label class="form-check-label" for="change_path">Rider</label>
                                            </div>
                                            @else
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="change_path"
                                                    name="change_path" value="Rider">
                                                <label class="form-check-label" for="change_path">Rider</label>
                                            </div>
                                            @endif
                                            @if($user->path === 'Vendor')
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="change_path"
                                                    name="change_path" value="Vendor" checked>
                                                <label class="form-check-label" for="change_path">Vendor</label>
                                            </div>
                                            @else
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="change_path"
                                                    name="change_path" value="Vendor">
                                                <label class="form-check-label" for="change_path">Vendor</label>
                                            </div>
                                            @endif
                                            @if($user->path === 'User')
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="change_path"
                                                    name="change_path" value="User" checked>
                                                <label class="form-check-label" for="change_path">User</label>
                                            </div>
                                            @else
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" id="change_path"
                                                    name="change_path" value="User">
                                                <label class="form-check-label" for="change_path">User</label>
                                            </div>
                                            @endif
                                        </div>
                                    </td>
                                    <td><button type="submit" class="btn btn-info btn-sm">Change</button></td>
                                </form>
                                @empty
                                <td class="text-warning">No user avaliable</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{ $get_user_details->withQueryString()->links() }}
                </div>
            </div>
            <!-- /Account -->
        </div>
    </div>
    </div>
    <div class="col-md-12 pt-3">
        <div class="card">
            <h5 class="card-header">
                Rider
            </h5>
            <hr class="my-0">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Serial</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <th>Current Zone</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($get_rider_details as $rider_details)
                            <tr>
                                <td>{{ $rider_details->serial }}</td>
                                <td>{{ $rider_details->name }}</td>
                                <td>{{ $rider_details->phone }}</td>
                                <td>{{ $rider_details->status }}</td>
                                <td>{{ $rider_details->location }}</td>
                                <form action="{{ route('change.rider_location') }}" method="POST">
                                    @csrf
                                    <td>
                                    <input type="text" value="{{ $rider_details->serial }}" hidden name="serial">
                                    <select name="location" class="form-select">
                                        @forelse($fetch_zone as $location)
                                        <option value="{{ $location->zone }}">{{ $location->zone }}</option>
                                        @empty
                                        <option>No Laction has been set yet</option>
                                        @endif
                                    </select>
                                    </td>
                                    <td><button type="submit" class="btn btn-info btn-sm">Change</button></td>
                                </form>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="7">
                                    <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="800px"
                                        alt="Card image">
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
