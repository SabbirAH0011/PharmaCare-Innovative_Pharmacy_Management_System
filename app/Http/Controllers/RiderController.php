<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\RiderLocation;
use App\Models\Order;
use Carbon\Carbon;
use Session;

class RiderController extends Controller
{
    public function ViewRiderDashboard(){
        if(Session::get('path') === 'Rider'){
            $rider_serial = Session::get('serial');
            $get_rider_location = RiderLocation::where('user_serial',$rider_serial)->take(1)->get();
            foreach($get_rider_location as $rider_location){
                $location = $rider_location->location;
            }
            $get_oder_details = DB::table('orders')->where([
                ['delivery_status','=','Unpicked'],
                ['location','=',$location],
                ])->orderBy('serial','DESC')->paginate(2);
            $get_oder_details_rider = DB::table('orders')
            ->join('user_admin_employee_accesses','orders.client_serial','user_admin_employee_accesses.serial')
            ->where([
                ['orders.location','=',$location],
                ['orders.rider_serial','=',$rider_serial],
                ])
            ->select('orders.*','user_admin_employee_accesses.name As client_name','user_admin_employee_accesses.phone As client_phone')
            ->orderBy('serial','DESC')
            ->paginate(2);
           return view('auth.dashboard.rider.rider.dashboard',compact('get_oder_details','get_oder_details_rider'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function ChangeOrderStatus(Request $req){
        if(Session::get('path') === 'Rider'){
            $order_id = $req->order_id;
            $change_status = $req->change_status;
            $rider_serial = Session::get('serial');
            if($change_status === 'Completed'){
                Order::where('serial',$order_id)->update([
                'payment_status' => 'Paid',
                'delivery_status' => $change_status,
                'rider_serial' => $rider_serial,
                'updated_at' => Carbon::now()
            ]);
            }else{
                Order::where('serial',$order_id)->update([
                'delivery_status' => $change_status,
                'rider_serial' => $rider_serial,
                'updated_at' => Carbon::now()
            ]);
            }
            return redirect()->back();
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }
}
