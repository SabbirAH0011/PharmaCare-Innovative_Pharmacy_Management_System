@extends('frontend.web.layout.dashboard-master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-header">Order from site</h5>
                        <hr class="my-0">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>Client</th>
                                        <th>Details</th>
                                        <th>Price</th>
                                        <th>Tracking</th>
                                    </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                    @forelse($get_oder_details as $order_details)
                                    <tr>
                                        <td>
                                            {{ $order_details->serial }} [{{ $order_details->location }}]
                                        </td>
                                        <td>
                                            {{ $order_details->client_name }} <br>
                                            {{ $order_details->client_phone }}
                                        </td>
                                        <td>
                                            @foreach(json_decode($order_details->product_detail_group,true) as $key=> $pd)
                                            <ul class="list-group pt-2">
                                                <li class="list-group-item">
                                                    Medicine name: <span class="text-primary">{{ $pd['medicine_name'] }}</span><br>
                                                    type: <span class="text-primary">{{ $pd['medicine_type'] }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    Drug Description: <span class="text-primary">{{ \Illuminate\Support\Str::limit($pd['description'], 15,
                                                        $end='...') }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    Manufacturer: <span class="text-primary">{{ $pd['manufacturer'] }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    Store: <span class="text-primary">{{ $pd['vendor_name'] }},{{ $pd['vendor_zone'] }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    Price: <span class="text-primary">{{ $pd['price'] }}</span>
                                                </li>
                                            </ul>
                                            @endforeach
                                            @if($order_details->delivery_status === 'Unpicked')
                                            <div class="pt-3">
                                                <a href="{{ route('remove.request',['serial'=> $order_details->serial]) }}" class="btn btn-danger btn-sm">Remove Request</a>
                                            </div>
                                             @endif
                                        </td>
                                        <td>
                                            <table class="table table-bordered table-primary">
                                                <thead>
                                                    <tr>
                                                        <th colspan="2" class="text-center">Calculation</th>
                                                    </tr>
                                                </thead>
                                                <tr>
                                                    <th>Total Product Price</th>
                                                    <td>{{ $order_details->total_price }} BDT</td>
                                                </tr>
                                                <tr>
                                                    <th>Delivery Charge</th>
                                                    <td>{{ $order_details->deilvery_charge }} BDT</td>
                                                </tr>
                                                <tr>
                                                    <th>Total Amount</th>
                                                    <td>{{ $order_details->total_amount }} BDT</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Method</th>
                                                    <td>{{ $order_details->payment_method }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Method</th>
                                                    <td>
                                                        {{ $order_details->payment_method }} <br>
                                                        [{{ $order_details->payment_status }}]
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td>
                                            <div class="card shadow p-2">
                                                <div class="card-body">
                                                    <h6>Tracking</h6>
                                                    <hr>
                                                    @if($order_details->delivery_status === 'Unpicked')
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar"
                                                            aria-valuenow="25" aria-valuemin="0" aria-valuemax="100" style="width: 25%">
                                                        </div>

                                                    </div>
                                                    <div class="text-center">
                                                        <label for="progress">Status: {{ $order_details->delivery_status }}</label>
                                                    </div>
                                                    @elseif($order_details->delivery_status === 'Picked')
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar"
                                                            aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                                        </div>

                                                    </div>
                                                    <div class="text-center">
                                                        <label for="progress">Status: {{ $order_details->delivery_status }} [Rider: {{ $order_details->rider_serial }}]</label>
                                                    </div>
                                                    @elseif($order_details->delivery_status === 'On the way')
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar"
                                                            aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                                                        </div>

                                                    </div>
                                                    <div class="text-center">
                                                        <label for="progress">Status: {{ $order_details->delivery_status }} [Rider: {{ $order_details->rider_serial }}]</label>
                                                    </div>
                                                    @elseif($order_details->delivery_status === 'Completed')
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                                                            aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                        </div>

                                                    </div>
                                                    <div class="text-center">
                                                        <label for="progress">Status: {{ $order_details->delivery_status }} [Rider: {{ $order_details->rider_serial }}]</label>
                                                    </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td>
                                            <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="800px"
                                                alt="Card image">
                                        </td>
                                    </tr>
                                    @endforelse
                                    {{ $get_oder_details->withQueryString()->links() }}
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-12 pt-3">
        <div class="card mb-4">
            <h5 class="card-header">Ambulance Booking 🚑 (Details)</h5>
            <!-- Account -->
            <hr class="my-0">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Booking</th>
                                <th>Location</th>
                                <th>Pickup Address</th>
                                <th>Destination</th>
                                <th>Ambulance N/P</th>
                                <th>Ambulance Type</th>
                                <th>Driver</th>
                                <th>Driver contact</th>
                                <th>total Bill</th>
                                <th>Partial Payemtn</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                                @forelse($get_booking_details as $ambulance)
                                <tr>
                                    <td>{{ $ambulance->serial }}</td>
                                    <td>{{ $ambulance->location }}</td>
                                    <td>{{ $ambulance->address }}</td>
                                    <td>{{ $ambulance->destination }}</td>
                                    <td>{{ $ambulance->number_plate }}</td>
                                    <td>{{ $ambulance->type }}</td>
                                    <td>{{ $ambulance->name }}</td>
                                    <td>{{ $ambulance->phone }}</td>
                                    <td>
                                        {{ $ambulance->total }}<br>
                                        @if(empty($ambulance->total_payment_status))
                                        <span class="badge rounded-pill bg-danger">Unpaid</span>
                                        @else
                                        @if($ambulance->total_payment_status ==='succeeded')
                                        <span class="badge rounded-pill bg-success">Paid</span>
                                        else
                                        <span class="badge rounded-pill bg-danger">Unpaid</span>
                                        @endif
                                        @endif
                                    </td>
                                    <td>
                                        {{ $ambulance->partial }}<br>
                                        @if(empty($ambulance->partial_payment_status))
                                        <span class="badge rounded-pill bg-danger">Unpaid</span>
                                        @else
                                        @if($ambulance->partial_payment_status ==='succeeded')
                                        <span class="badge rounded-pill bg-success">Paid</span>
                                        @else
                                        <span class="badge rounded-pill bg-danger">Unpaid</span>
                                        @endif
                                        @endif
                                    </td>
                                    <td>{{ $ambulance->status }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td class="text-warning">No booking avaliable</td>
                                </tr>
                                @endforelse

                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Account -->
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Vendor Store 🏪 (Registration)</h5>
            <!-- Account -->
            <hr class="my-0">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Store</th>
                                <th>Owner</th>
                                <th>Owner contact</th>
                                <th>Address</th>
                                <th>Location</th>
                                <th>Phone</th>
                                <th>Status</th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($get_vendor_store as $store)
                            <tr>
                                <td>{{ $store->store_name }}</td>
                                <td>{{ $store->name }}</td>
                                <td>{{ $store->owner_phone }}</td>
                                <td>{{ $store->address }}</td>
                                <td>{{ $store->zone }}</td>
                                <td>{{ $store->phone }}</td>
                                <td>{{ $store->status }}</td>
                                <td>
                                    <form action="{{ route('change.vendor_status') }}" method="POST">
                                        @csrf
                                        <div class="col-md">
                                            <input type="email" value="{{ $store->email }}" id="email" name="email" hidden>
                                            <input type="text" value="{{ $store->serial }}" id="serial" name="serial" hidden>
                                            <input type="text" value="{{ $store->name }}" id="owner" name="owner" hidden>
                                            <input type="text" value="{{ $store->store_name }}" id="store_name" name="store_name" hidden>
                                            <input type="text" value="{{ $store->zone }}" id="zone" name="zone" hidden>
                                            @if( $store->status === 'Pending')
                                            <div class="form-check form-check">
                                                <input class="form-check-input" type="radio" id="change_path" name="change_permission" value="Approved">
                                                <label class="form-check-label" for="change_path">Make Approved</label>
                                            </div>
                                            <div class="form-check form-check">
                                                <input class="form-check-input" type="radio" id="change_path" name="change_permission" value="Pending" checked>
                                                <label class="form-check-label" for="change_path">Make Pending</label>
                                            </div>
                                            @else
                                            <div class="form-check form-check">
                                                <input class="form-check-input" type="radio" id="change_path" name="change_permission" value="Approved" checked>
                                                <label class="form-check-label" for="change_path">Make Approved</label>
                                            </div>
                                            <div class="form-check form-check">
                                                <input class="form-check-input" type="radio" id="change_path" name="change_permission" value="Pending">
                                                <label class="form-check-label" for="change_path">Make Pending</label>
                                            </div>
                                            @endif
                                        </div>
                                        <div class="col-md">
                                            <button type="submit" class="btn btn-info btn-sm">Change</button>
                                        </div>
                                    </form>
                                </td>
                            </tr>
                                @empty
                                <tr>
                                    <td>No vendor store registered</td>
                                </tr>

                                @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $get_vendor_store->withQueryString()->links() }}
            </div>
            <!-- /Account -->
        </div>
    </div>
</div>
@endsection
