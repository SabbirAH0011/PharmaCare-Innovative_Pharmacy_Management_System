<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Illuminate\Support\Facades\DB;

class AmbulanceController extends Controller
{
    public function ViewAmbulanceDashboard(){
        if(Session::get('path') === 'Ambulance-driver'){
            $client_serial = Session::get('serial');
            $get_booking_details = DB::table('booked_ambulances')
            ->join('ambulances','booked_ambulances.ambulance_no','ambulances.serial')
            ->join('user_admin_employee_accesses','ambulances.driver_serial','user_admin_employee_accesses.serial')
            ->where('ambulances.driver_serial','=',$client_serial)
            ->select('booked_ambulances.*','user_admin_employee_accesses.name','user_admin_employee_accesses.phone',
            'ambulances.number_plate','ambulances.type')
            ->orderBy('booked_ambulances.serial','DESC')
            ->get();
            return view('auth.dashboard.rider.ambulance.dashboard',compact('get_booking_details'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }
}
