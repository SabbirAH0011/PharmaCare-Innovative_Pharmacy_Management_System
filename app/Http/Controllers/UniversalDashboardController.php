<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAdminEmployeeAccess;
use Session;
use App\Models\Location;
use App\Models\Ambulance;
use App\Models\BookedAmbulance;
use Carbon\Carbon;
use Stripe\StripeClient;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\Order;
use Symfony\Component\HttpFoundation\Response;

class UniversalDashboardController extends Controller
{
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
    }
    public function ViewAccountSettings(Request $req){
        if((Session::get('path') === 'Admin')||(Session::get('path') === 'User')
        ||(Session::get('path') === 'Ambulance-driver')||(Session::get('path') === 'Vendor')){
            $user_email = Session::get('email');
            $user_access_token = Session::get('access_token');
            $get_user_details = UserAdminEmployeeAccess::where([
                ['email','=',$user_email],
                ['access_token','=',$user_access_token],
            ])
            ->get();
            foreach($get_user_details as $user){
                $name = $user->name;
                $phone = $user->phone;
            }
            return view('auth.dashboard.universal.account_details',compact('name','phone'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function StoreAccountSettings(Request $req){
        if((Session::get('path') === 'Admin')||(Session::get('path') === 'User')
        ||(Session::get('path') === 'Ambulance-driver')||(Session::get('path') === 'Vendor')){
            $validator = $req->validate([
               'name' => 'required|max:255',
               'phone' => 'required|numeric|digits:11',
           ]);
           $name = $req->name;
           $phone = $req->phone;
           $user_email = Session::get('email');
           $user_access_token = Session::get('access_token');
           $update_details = UserAdminEmployeeAccess::where([
                ['email','=',$user_email],
                ['access_token','=',$user_access_token],
            ])
            ->update([
                'name' => $name,
                'phone' => $phone,
                'updated_at' => Carbon::now()
            ]);
            if($update_details){
                return redirect()->back()->with(['success' => 'Your account details successfully updated']);
            }else{
                return redirect()->back()->withErrors(['error' => 'Could not update your account details']);
            }
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function SelectLocationBookingView(){
        $fetch_zone = Location::all();
        return view('auth.dashboard.universal.ambulance_booking.location_and_form',compact('fetch_zone'));
    }

    public function BookAmbulanceNowView(Request $req){
        $location = $req->location;
        $get_ambulance = DB::table('ambulances')
        ->where([
            ['zone','=',$location],
            ['status','=','Open']
        ])
        ->get();
        return view('auth.dashboard.universal.ambulance_booking.book_now',compact('get_ambulance'));
    }

    public function SubmitAmbulanceBooking(Request $req){
        $validator = $req->validate([
               'card_number' => 'required|numeric|digits:16',
               'year' => 'required|numeric|digits:2',
               'month' => 'required|numeric|digits:2',
               'cvc' => 'required|numeric|digits:4',
        ]);
        $card_number = $req->card_number;
        $year = $req->year;
        $month = $req->month;
        $cvc = $req->cvc;
        $location = $req->location;
        $selected_ambulance = $req->selected_ambulance;
        $address = $req->address;
        $destination = $req->destination;

        $serial = IdGenerator::generate(['table' => 'booked_ambulances', 'field' => 'serial', 'length' => 10, 'prefix' => 'bamb-']);
        $description = 'Ambulance partial bill on - '.$serial;

        $get_ambulance_details = Ambulance::where('serial','=',$selected_ambulance)
        ->take(1)
        ->get();
        foreach($get_ambulance_details as $ambulance){
            $price = $ambulance->price;
            $number_plate = $ambulance->number_plate;
            $driver_serial = $ambulance->driver_serial;
        }
        $get_ambulance_driver_details = UserAdminEmployeeAccess::where('serial',$driver_serial)->take(1)->get();
        foreach($get_ambulance_driver_details as $driver){
            $driver_email = $driver->email;
            $driver_name = $driver->name;
            $driver_phone = $driver->phone;
        }
        $pertial_payment = ($price*10)/100;
        $pertial_payment_dollar = ceil($pertial_payment*100);
         $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $card_number,
                    'exp_month' => $month,
                    'exp_year' => $year,
                    'cvc' => $cvc
                ]
            ]);
         $charge = $this->stripe->charges->create([
                'amount' => $pertial_payment_dollar,
                'currency' => 'usd',
                'source' => $token,
                'description' => $description
            ]);
        if($charge){
            $client_serial = Session::get('serial');
            $insert_booking = BookedAmbulance::insert([
                'serial' =>$serial,
                'location' =>$location,
                'address' => $address,
                'destination' => $destination,
                'total' => $price,
                'partial' => $pertial_payment,
                'partial_payment_status' => $charge['status'],
                'ambulance_no' => $selected_ambulance,
                'booked_by' => $client_serial,
                'created_at' => Carbon::now()
            ]);
            $update_ambulance_status = Ambulance::where('serial',$selected_ambulance)
            ->update([
                'status' => 'Closed',
                'updated_at' => Carbon::now()
            ]);
            if($insert_booking && $update_ambulance_status){
                $client_email = Session::get('email');
                $driver_email = $driver_email;
                $client_text = 'হ্যালো, আপনার এম্বুলেন্স বুকিং সাকসেসফুল। ড্রাইভারের সাথে কন্টাক করতে নিচের ডিটেলস দেখুন - ';
                $driver_text = 'হ্যালো, ক্লাইন্ট আপনার এম্বুলেন্স বুক করেছে। ডেস্টিনেশন পেতে নিচের ডিটেলস দেখুন - ';
                $client_data=[
                          'client_text'=> $client_text,
                          'driver_name'=> $driver_name,
                          'driver_phone'=> $driver_phone,
                          'number_plate' => $number_plate
                      ];
                $driver_data=[
                          'driver_text'=> $driver_text,
                          'address'=> $address,
                          'destination'=> $destination,
                          'location'=> $location
                      ];
                $client['to']= $client_email;
                      Mail::send('emails.ambulance_booking_client',$client_data,function($mail)use($client){
                           $mail->to($client['to']);
                           $mail->subject('Ambulance Booking (Client confirmation) - Pharma Check ['.date("l jS \of F Y").']');
                          });
                $driver['to']= $driver_email;
                      Mail::send('emails.ambulance_booking_driver',$driver_data,function($mail)use($driver){
                           $mail->to($driver['to']);
                           $mail->subject('Ambulance Booking (Driver confirmation) - Pharma Check ['.date("l jS \of F Y").']');
                          });
                return redirect()->route('welcome',['success'=>'Ambulance booking successful']);
            }else{
                 return redirect()->back()->withErrors(['error' => 'Could not submit ambulance booking']);
            }
        }
    }

    public function InvoiceView(Request $req){
        $payment_token = $req->token;
        $verify_token = Order::where('payment_token',$payment_token)->exists();
        if(!empty($payment_token)&&($verify_token === true )){
            $get_details = DB::table('orders')
            ->join('user_admin_employee_accesses','orders.client_serial','user_admin_employee_accesses.serial')
            ->where('orders.payment_token',$payment_token)
            ->select('orders.*','user_admin_employee_accesses.name','user_admin_employee_accesses.phone')
            ->take(1)
            ->get();
            foreach($get_details as $decoded_details){
                $product_json = json_decode($decoded_details->product_detail_group,true);
            }
            return view('frontend.web.pages.invoice',compact('get_details','product_json'));
        }else{
            return  new Response(view('errors.204'));
        }
    }
}
