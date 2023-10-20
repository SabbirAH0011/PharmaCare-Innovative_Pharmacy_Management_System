@extends('frontend.web.layout.dashboard-master')
@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
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
                            @forelse($get_oder_details_rider as $order_details)
                            <tr>
                                <td>
                                    {{ $order_details->serial }} [{{ $order_details->location }}]
                                </td>
                                <td>
                                    {{ $order_details->client_name }} <br>
                                    {{ $order_details->client_phone }} <br>
                                    <p>Address: <span class="text-primary">{{ $order_details->shipping_address }}</span></p>
                                </td>
                                <td>
                                    @foreach(json_decode($order_details->product_detail_group,true) as $key=> $pd)
                                    <ul class="list-group pt-2">
                                        <li class="list-group-item">
                                            Medicine name: <span class="text-primary">{{ $pd['medicine_name'] }}</span><br>
                                            type: <span class="text-primary">{{ $pd['medicine_type'] }}</span>
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
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                                    role="progressbar" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 25%">
                                                </div>

                                            </div>
                                            <div class="text-center">
                                                <label for="progress">Status: {{ $order_details->delivery_status }}</label>
                                            </div>
                                            @elseif($order_details->delivery_status === 'Picked')
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                                    role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 50%">
                                                </div>

                                            </div>
                                            <div class="text-center">
                                                <label for="progress">Status: {{ $order_details->delivery_status }} [Rider: {{
                                                    $order_details->rider_serial }}]</label>

                                            </div>
                                            <div class="mb-3">
                                                <label for="staticEmail" class="col-sm-4 col-form-label">Change Tracking </label> <br>
                                                    <a class="btn btn-primary"
                                                        href="{{ route('rider.change_status',['order_id' => $order_details->serial,'change_status' => 'On the way']) }}">On
                                                        the way</a>
                                            </div>
                                            @elseif($order_details->delivery_status === 'On the way')
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                                    role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 75%">
                                                </div>

                                            </div>
                                            <div class="text-center">
                                                <label for="progress">Status: {{ $order_details->delivery_status }} [Rider: {{
                                                    $order_details->rider_serial }}]</label>

                                            </div>
                                            <div class="mb-3">
                                                <label for="staticEmail" class="col-sm-4 col-form-label">Change Tracking </label> <br>
                                                <a class="btn btn-primary"
                                                    href="{{ route('rider.change_status',['order_id' => $order_details->serial,'change_status' => 'Completed']) }}">Completed</a>
                                            </div>
                                            @elseif($order_details->delivery_status === 'Completed')
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                    role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100"
                                                    style="width: 100%">
                                                </div>

                                            </div>
                                            <div class="text-center">
                                                <label for="progress">Status: {{ $order_details->delivery_status }} [Rider: {{
                                                    $order_details->rider_serial }}]</label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6">
                                    <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}"
                                        height="800px" alt="Card image">
                                </td>
                            </tr>
                            @endforelse
                            {{ $get_oder_details_rider->withQueryString()->links() }}
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 pt-3">
        <div class="card mb-4">
            <div class="card-body">
                <h5 class="card-header">Pick Orders 📃</h5>
                <hr>
                <div class="row mb-5">
                    @forelse($get_oder_details as $order_details)
                    <div class="col-md-12 col-xl-6">
                        <div class="pt-2">
                            <div class="card shadow p-3 mb-5">
                                <div class="card-body">
                                    <h5 class="card-title">{{ $order_details->serial }} [{{ $order_details->location }}]</h5>
                                    <br>
                                    <div class="row">
                                        <div class="col">
                                            <p>Address: <span class="text-primary">{{ $order_details->shipping_address }}</span></p>
                                        </div>
                                    </div>
                                    <hr class="text-primary">
                                    <div class="row">
                                        <div class="col-6">
                                            @foreach(json_decode($order_details->product_detail_group,true) as $key=> $pd)
                                            <ul class="list-group pt-2">
                                                <li class="list-group-item">
                                                    Medicine name: <span class="text-primary">{{ $pd['medicine_name']
                                                        }}</span><br>
                                                    type: <span class="text-primary">{{ $pd['medicine_type'] }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    Drug Description: <span class="text-primary">{{
                                                        \Illuminate\Support\Str::limit($pd['description'], 150,
                                                        $end='...') }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    Manufacturer: <span class="text-primary">{{ $pd['manufacturer'] }}</span>
                                                </li>
                                                <li class="list-group-item">
                                                    Store: <span class="text-primary">{{ $pd['vendor_name'] }},{{
                                                        $pd['vendor_zone'] }}</span>
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
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger"
                                                                    role="progressbar" aria-valuenow="25" aria-valuemin="0"
                                                                    aria-valuemax="100" style="width: 25%">
                                                                </div>

                                                            </div>
                                                            <div class="text-center">
                                                                <label for="progress">Status: {{ $order_details->delivery_status
                                                                    }}</label>
                                                            </div>
                                                            @elseif($order_details->delivery_status === 'Picked')
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning"
                                                                    role="progressbar" aria-valuenow="50" aria-valuemin="0"
                                                                    aria-valuemax="100" style="width: 50%">
                                                                </div>

                                                            </div>
                                                            <div class="text-center">
                                                                <label for="progress">Status: {{ $order_details->delivery_status
                                                                    }}</label>
                                                            </div>
                                                            @elseif($order_details->delivery_status === 'On the way')
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary"
                                                                    role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                                    aria-valuemax="100" style="width: 75%">
                                                                </div>

                                                            </div>
                                                            <div class="text-center">
                                                                <label for="progress">Status: {{ $order_details->delivery_status
                                                                    }}</label>
                                                            </div>
                                                            @elseif($order_details->delivery_status === 'Completed')
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success"
                                                                    role="progressbar" aria-valuenow="100" aria-valuemin="0"
                                                                    aria-valuemax="100" style="width: 100%">
                                                                </div>

                                                            </div>
                                                            <div class="text-center">
                                                                <label for="progress">Status: {{ $order_details->delivery_status
                                                                    }}</label>
                                                            </div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row pt-3">
                                                <div class="col">
                                                    <div class="card">
                                                        <div class="card-body">
                                                           <a class="btn btn-primary" href="{{ route('rider.change_status',['order_id' => $order_details->serial,'change_status' => 'Picked']) }}">Pick the order</a>
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
</div>
@endsection
