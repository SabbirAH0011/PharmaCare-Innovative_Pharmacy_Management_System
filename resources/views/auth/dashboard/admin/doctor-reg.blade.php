@extends('frontend.web.layout.dashboard-master')
@section('content')
<style>
    .holder {
        height: 300px;
        width: 300px;
        border: 2px solid black;
    }

    img {
        max-width: 300px;
        max-height: 300px;
        min-width: 300px;
        min-height: 300px;
    }

    input[type="file"] {
        margin-top: 5px;
    }

    .heading {
        font-family: Montserrat;
        font-size: 45px;
        color: green;
    }
</style>
<div class="row">
    <div class="col-md-8 col-sm-12">
            <div class="nav-align-top mb-4">
                <ul class="nav nav-pills mb-3" role="tablist">
                    <li class="nav-item">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-home" aria-controls="navs-pills-top-home" aria-selected="true">
                            Appointment
                        </button>
                    </li>
                    <li class="nav-item">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                            data-bs-target="#navs-pills-top-profile" aria-controls="navs-pills-top-profile"
                            aria-selected="false">
                            Doctor list
                        </button>
                    </li>

                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="navs-pills-top-home" role="tabpanel">
                        <div class="table-responsive text-nowrap">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Appointment</th>
                                        <th>Doctor</th>
                                        <th>Patient</th>
                                        <th>Visiting time & day</th>
                                        <th>Status</th>
                                        <th></th>
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
                                        <td>
                                            <form action="{{ route('change.appintment_status') }}" method="POST">
                                                @csrf
                                                    <input type="text" value="{{ $appointment->serial }}" hidden name="serial">
                                                        @if($appointment->status === 'Unapproved')
                                                        <input type="text" value="Approved" name="status" hidden>
                                                        <button type="submit" class="btn btn-info btn-sm">Make Approve</button>
                                                        @else
                                                        <input type="text" value="Unapproved" name="status" hidden>
                                                        <button type="submit" class="btn btn-warning btn-sm">Make Unapprove</button>
                                                        @endif
                                                    </select>

                                            </form>
                                        </td>
                                        @empty
                                        <td class="text-warning">No appointment avaliable</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $get_appointment->withQueryString()->links() }}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                                <div class="row mb-5">
                                    @forelse($doctors as $dr)
                                    <div class="col-md-6 col-xl-4">
                                        <div class="pt-2">
                                            <div class="card">
                                                <div class="card-body">
                                                    <h5 class="card-title">{{ $dr->name }}</h5>
                                                    <div class="text-center bg-primary">
                                                        @if(!empty($dr->image))
                                                        <img src="{{ asset($dr->image) }}" class="img-thumbnail" alt="{{ $dr->name }}">
                                                        @else
                                                        <h2 class="pt-5 pb-5 text-center text-white">{{ \Illuminate\Support\Str::limit(
                                                            $dr->name , 1,$end='' ) }}</h2>
                                                        @endif
                                                    </div>

                                                    <div class="card-text">
                                                        <ul class="list-group list-group-flush">
                                                            <li class="list-group-item">{{ $dr->degree }}</li>
                                                            <li class="list-group-item">Specialist: {{ $dr->speciality }}</li>
                                                            <li class="list-group-item">Hospital: {{ $dr->hospital }}</li>
                                                            <li class="list-group-item">Visiting Hr: {{ $dr->time }}</li>
                                                            <li class="list-group-item">Visiting day:
                                                                @foreach(json_decode($dr->day,true) as $key=> $vd)
                                                                <span class="badge rounded-pill bg-info">{{ $vd['day'] }}</span>
                                                                @endforeach
                                                            </li>
                                                        </ul>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @empty
                                    <img class="card-img darkened-image" src="{{ asset('assets/img/sites/not_found.jpg') }}" height="800px"
                                        alt="Card image">
                                    @endforelse

                                </div>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $doctors->withQueryString()->links() }}
                            </div>

                </div>
            </div>
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Register New Doctor</h5>
                <form action="{{ route('store.doctor') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @if(session()->has('success_doctor'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session()->get('success_doctor') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @endif
                    @error('error')
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        {{ $message }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    @enderror
                    <div class="mb-3">
                        <div class="holder">
                            <img id="imgPreview" src="#" alt="pic" />
                        </div>
                        <label for="defaultInput" class="form-label">Upload image</label>
                        <input type="file" class="form-control" id="main_image" name="main_image">
                        @error('main_image')
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="defaultInput" class="form-label">Name</label>
                        <input class="form-control" type="text" name="name">
                        @error('name')
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="defaultInput" class="form-label">Degree</label>
                        <input class="form-control" type="text" name="degree">
                        @error('degree')
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="defaultInput" class="form-label">Speciality</label>
                        <input class="form-control" type="text" name="speciality">
                        @error('speciality')
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="defaultInput" class="form-label">Hospital</label>
                        <input class="form-control" type="text" name="hospital">
                        @error('hospital')
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="defaultInput" class="form-label">time</label>
                        <div class="row">
                            <div class="col-6">
                                <input class="form-control" type="time" name="from_time">
                                @error('from_time')
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @enderror
                            </div>
                            <div class="col-6">
                                <input class="form-control" type="time" name="to_time">
                                @error('to_time')
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    {{ $message }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="defaultInput" class="form-label">Day</label>
                        <input class="form-control" type="text" name="day[]"  oninput="this.value = this.value.toUpperCase()">
                        <table class="table  table-hover" id="dynamic_field">
                            <tbody>

                            </tbody>
                        </table>
                        <div class="pt-3 text-center">
                            <button type="button" name="add" id="add" class="btn btn-success btn-sm">+ Add another day</button>
                        </div>

                        @error('day.*')
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {{ $message }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary d-grid w-100" id="send_otp">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(() => {
        $('#main_image').change(function () {
            const file = this.files[0];
            console.log(file);
            if (file) {
                let reader = new FileReader();
                reader.onload = function (event) {
                    console.log(event.target.result);
                    $('#imgPreview').attr('src', event.target.result);
                }
                reader.readAsDataURL(file);
            }
        });
    });
//add more
$(document).ready(function(){
            var i=1;
            $('#add').click(function(){
                i++;
            $('#dynamic_field').append('<tr id="row'+i+'" class="dynamic-added"><td><input type="text " oninput="this.value = this.value.toUpperCase()" class="form-control" name="day[]" class="form-control"></td><td><button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button></td></tr>');
    });

    $(document).on('click', '.btn_remove', function(){
    var button_id = $(this).attr("id");
            $('#row'+button_id+'').remove();
    });
});

</script>
@endsection
