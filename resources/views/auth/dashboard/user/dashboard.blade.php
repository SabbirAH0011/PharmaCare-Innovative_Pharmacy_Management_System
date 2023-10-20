@extends('frontend.web.layout.dashboard-master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Doctor Appointment</h5>
            <!-- Account -->
            <hr class="my-0">
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Appointment</th>
                                <th>Doctor</th>
                                <th>Patient</th>
                                <th>Visiting time & day</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody class="table-border-bottom-0">
                            @forelse($get_appointment as $appointment)
                            <tr>
                                <td>{{ $appointment->serial }}</td>
                                <td>
                                    {{ $appointment->name }} <br>
                                    {{ $appointment->degree }} <br>
                                    {{ $appointment->speciality }} <br>
                                    {{ $appointment->hospital }} <br>
                                </td>
                                <td>
                                    {{ $appointment->patient_name }} <br>
                                    {{ $appointment->patient_age }} y/o<br>
                                </td>
                                <td>
                                    {{ $appointment->time }} <br>
                                    {{ $appointment->visiting_day }}
                                </td>
                                <td>
                                    {{ $appointment->status }}
                                </td>
                                @empty
                                <td class="text-warning">No appointment avaliable</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                {{ $get_appointment->withQueryString()->links() }}
            </div>
            <!-- /Account -->
        </div>
    </div>
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-header">Product Orders 📃</h5>
                <hr>
                <div class="row mb-5">
                    @forelse($get_oder_details as $order_details)
                    <div class="col-md-12 col-xl-6">
                        <div class="pt-2">
                            <div class="card shadow p-3 mb-5">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $order_details->serial }} [{{ $order_details->location }}]</h5>
                                    <hr class="text-primary">
                                    <div class="row">
                                        <div class="col-6">
                                            @foreach(json_decode($order_details->product_detail_group,true) as $key=> $pd)
                                            <ul class="list-group pt-2">
                                                <li class="list-group-item">
                                                    Medicine name: <span class="text-primary">{{ $pd['medicine_name'] }}</span><br>
                                                    type: <span class="text-primary">{{ $pd['medicine_type'] }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    Drug Description: <span class="text-primary">{{ \Illuminate\Support\Str::limit($pd['description'], 150,
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
                                        </div>
                                        <div class="col-6">
                                            <div class="pt-2">
                                                <div class="table-responsive">
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
                                                </div>
                                            </div>
                                            <div class="row pt-5">
                                                <div class="col">
                                                    <div class="card shadow p-2">
                                                        <div class="card-body">
                                                            <h6>Tracking</h6>
                                                            <hr>
                                                            @if($order_details->delivery_status === 'Unpicked')
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="25"
                                                                    aria-valuemin="0" aria-valuemax="100" style="width: 25%">
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
                                                                <label for="progress">Status: {{ $order_details->delivery_status }}</label>
                                                            </div>
                                                            @elseif($order_details->delivery_status === 'On the way')
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar"
                                                                    aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 75%">
                                                                </div>

                                                            </div>
                                                            <div class="text-center">
                                                                <label for="progress">Status: {{ $order_details->delivery_status }}</label>
                                                            </div>
                                                            @elseif($order_details->delivery_status === 'Completed')
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar"
                                                                    aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%">
                                                                </div>

                                                            </div>
                                                            <div class="text-center">
                                                                <label for="progress">Status: {{ $order_details->delivery_status }}</label>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="800px"
                        alt="Card image">
                    @endforelse
                    {{ $get_oder_details->withQueryString()->links() }}
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12">
        <div class="card mb-4">
            <h5 class="card-header">Ambulance Booking  🚑 (Details)</h5>
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
                                    @empty
                                    <td class="text-warning">No booking avaliable</td>
                                </tr>
                                @endforelse
                                {{ $get_booking_details->withQueryString()->links() }}
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- /Account -->
        </div>
    </div>
</div>
@endsection
