@extends('frontend.web.layout.dashboard-master')
@section('content')
    <div class="col-md-12">
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
                                @empty
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
@endsection
