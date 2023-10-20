<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use Haruncpi\LaravelIdGenerator\IdGenerator As IDGen;
use App\Models\MedicineList;
use App\Models\Location;
use App\Models\Order;
use App\Models\VendorOrderSerial;
use App\Models\DoctorAppointment;
use Session;
use Exception;
use Carbon\Carbon;
use Stripe\StripeClient;

class UserController extends Controller
{
    public function __construct()
    {
        $this->stripe = new StripeClient(config('stripe.api_keys.secret_key'));
    }
    public function ViewUserDashboard(){
        if(Session::get('path') === 'User'){
            $client_serial = Session::get('serial');
            $get_appointment = DB::table('doctor_appointments')
            ->join('doctors','doctor_appointments.doctor','doctors.serial')
            ->where('doctor_appointments.client_id','=',$client_serial)
            ->select('doctor_appointments.*','doctors.name','doctors.degree','doctors.speciality','doctors.hospital',
            'doctors.time')
            ->paginate(5);
            $get_booking_details = DB::table('booked_ambulances')
            ->join('ambulances','booked_ambulances.ambulance_no','ambulances.serial')
            ->join('user_admin_employee_accesses','ambulances.driver_serial','user_admin_employee_accesses.serial')
            ->where('booked_ambulances.booked_by','=',$client_serial)
            ->select('booked_ambulances.*','user_admin_employee_accesses.name','user_admin_employee_accesses.phone',
            'ambulances.number_plate','ambulances.type')
            ->orderBy('booked_ambulances.serial','DESC')
            ->paginate(5);
            $get_oder_details = DB::table('orders')->where('client_serial','=',$client_serial)->orderBy('serial','DESC')->paginate(2);
            return view('auth.dashboard.user.dashboard',compact('get_appointment','get_booking_details','get_oder_details'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function CartCount(){
        try{
            $serial = Session::get('serial');
            $verify_cart_item_existance = Cart::where('client_serial',$serial)->exists();
            if($verify_cart_item_existance === true){
                $total_count = Cart::where('client_serial',$serial)->count();
            }else{
                $total_count = 0;
            }
            return response()->json([
                      'status' => true,
                      'error' => 'no',
                      'total_count' => $total_count
                    ],200);
        }catch(Exception $e){
            $error = $e->getMessage();
            $line = $e->getLine();
            return response()->json([
                'status' => false,
                'error' => 'yes',
                'msg' => 'Exception occured: '.$error.' in line : '.$line,
            ],422);
        }
    }

    public function StoreAddToCartItem(Request $req){
        try{
            $client_serial = Session::get('serial');
            $product_serial = $req->product_id;
            $store_bought = $req->store_bought;
            if($store_bought > 0){
                $validate_existance = Cart::where('product_serial',$product_serial)->exists();
                if($validate_existance === true){
                    return response()->json([
                          'status' => false,
                          'error' => 'bad request',
                          'msg' => 'Product already added to cart'
                        ],400);
                }else{
                    $cart_serial = IDGen::generate(['table' => 'carts', 'field' => 'cart_serial', 'length' => 10, 'prefix' => 'crt-']);
                    $save_to_cart = new  Cart();
                    $save_to_cart->cart_serial = $cart_serial;
                    $save_to_cart->client_serial = $client_serial;
                    $save_to_cart->product_serial = $product_serial;
                    $save_to_cart->bought = $store_bought;
                    $save_to_cart->save();
                    return response()->json([
                              'status' => true,
                              'error' => 'no',
                              'msg' => 'Porduct added to cart'
                            ],200);
                }
            }else{
                return response()->json([
                          'status' => false,
                          'error' => 'bad request',
                          'msg' => 'Please add some item first'
                        ],400);
            }
        }catch(Exception $e){
            $error = $e->getMessage();
            $line = $e->getLine();
            return response()->json([
                'status' => false,
                'error' => 'yes',
                'msg' => 'Exception occured: '.$error.' in line : '.$line,
            ],422);
        }
    }

    public function ViewCart(){
         if(Session::get('path') === 'User'){
            $client_serial = Session::get('serial');
            $validate_existance = Cart::where('client_serial',$client_serial)->exists();
            $get_total_product = DB::table('carts')
            ->join('medicine_lists','carts.product_serial','medicine_lists.serial')
            ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
            ->where('carts.client_serial',$client_serial)
            ->select('medicine_lists.*','carts.bought','carts.cart_serial','vendor_stores.store_name','vendor_stores.zone')
            ->get();
            $product_price_array = array();
            foreach ($get_total_product as $product) {
                array_push($product_price_array,
                    $product->price*$product->bought
                );
            }
            $grand_total = array_sum($product_price_array);
             return view('auth.dashboard.user.cart',compact('get_total_product','grand_total','validate_existance'));
         }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function RemoveItemFromCart(Request $req){
        if(Session::get('path') === 'User'){
            $cart_serial = $req->cart_serial;
            Cart::where('cart_serial',$cart_serial)->delete();
            return redirect()->back()->with(['cart_success' => 'Item removed from cart']);
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function SetUserLocationView(){
        $fetch_zone = Location::all();
        return view('frontend.web.pages.page-chunks.user_location',compact('fetch_zone'));
    }

    public function StoreUserLocation(Request $req){
        $new_location = $req->location;
        Session::forget('user_location');
        Session::put(['user_location' => $new_location]);
        return redirect()->route('welcome');
    }

    public function CheckoutView(){
        if(Session::get('path') === 'User'){
            $client_serial = Session::get('serial');
            $validate_existance = Cart::where('client_serial',$client_serial)->exists();
            $user_location = Session::get('user_location');
            $get_total_product = DB::table('carts')
            ->join('medicine_lists','carts.product_serial','medicine_lists.serial')
            ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
            ->where('carts.client_serial',$client_serial)
            ->select('medicine_lists.*','carts.bought','carts.cart_serial','vendor_stores.store_name','vendor_stores.zone')
            ->get();
            $product_price_array = array();
            $zone = collect();
            foreach ($get_total_product as $product) {
                array_push($product_price_array,
                    $product->price*$product->bought
                );
                $zone->push([
                    'area' => $product->zone
                ]);
            }
            $grand_total = array_sum($product_price_array);
            if($zone->doesntContain('area', $user_location) === false){
                $delivery_charge = config('siteConfig.delivery_charge.inside_location');
            }else{
                $delivery_charge = config('siteConfig.delivery_charge.outside_location');
            }

            return view('auth.dashboard.user.checkout',compact('validate_existance','get_total_product','grand_total','delivery_charge'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function CheckoutStore(Request $req){
        if(Session::get('path') === 'User'){
            $user_location = Session::get('user_location');
            $validator = $req->validate([
               'shpping_address' => 'required',
               'payment_method' => 'required',
            ],[
              'shpping_address.required' => 'Please fill up shipping address',
              'payment_method.required' => 'Please select a payment method'
            ]);
            $delivery_charge = $req->delivery_charge;
            $payment_method = $req->payment_method;
            $shpping_address = $req->shpping_address;
            $client_serial = Session::get('serial');
            $user_location = Session::get('user_location');

            $get_total_product = DB::table('carts')
            ->join('medicine_lists','carts.product_serial','medicine_lists.serial')
            ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
            ->where('carts.client_serial',$client_serial)
            ->select('medicine_lists.*','carts.bought','carts.cart_serial','vendor_stores.store_name','vendor_stores.zone',
            'vendor_stores.serial As store_serial')
            ->get();
            $product_price_array = array();
            $product_details_collect = collect();
            $serial=IDGen::generate(['table' => 'orders', 'field' => 'serial', 'length' => 10, 'prefix' => 'odr-']);
            foreach($get_total_product as $product){
                if($product->total_stock >= $product->bought){
                    MedicineList::where('serial',$product->serial)->decrement('total_stock',$product->bought);
                    $product_details_collect->push([
                        'medicine_name' => $product->medicine_name,
                        'medicine_type' => $product->medicine_type,
                        'price' => $product->price,
                        'bought' => $product->bought,
                        'description' => $product->description,
                        'manufacturer' => $product->manufacturer,
                        'vendor_name' => $product->store_name,
                        'vendor_zone' => $product->zone,
                    ]);
                    array_push($product_price_array,
                      $product->price*$product->bought
                    );
                   VendorOrderSerial::insert([
                        'order_serial' => $serial,
                        'store_serial' => $product->store_serial,
                        'created_at' => Carbon::now()
                    ]);
                    Cart::where('cart_serial',$product->cart_serial)->delete();
                }
                $grand_total = array_sum($product_price_array);
                $token_generate = $serial.hexdec(uniqid());
            }
            Order::insert([
                        'serial' => $serial,
                        'client_serial' => $client_serial,
                        'product_detail_group' => json_encode($product_details_collect),
                        'shipping_address' => $shpping_address,
                        'total_price' => $grand_total,
                        'deilvery_charge' => (float)$delivery_charge,
                        'total_amount' => $grand_total+$delivery_charge,
                        'payment_method' => $payment_method,
                        'payment_token' => $token_generate,
                        'location' => $user_location,
                        'delivery_status' => 'Unpicked',
                        'created_at' => Carbon::now()
                    ]);
            if($payment_method === 'COD'){
                return redirect()->route('view.invoice',['token'=>$token_generate]);
            }else{
                return redirect()->route('pay.check_via_online_card',['payment_token'=>$token_generate]);
            }
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function PaymentOnlineCard(Request $req){
        if(Session::get('path') === 'User'){
             return view('auth.dashboard.user.payment_card');
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function SubmitPaymentOnlineCard(Request $req){
        if(Session::get('path') === 'User'){
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
        $payment_token = $req->payment_token;
        $get_details = Order::where([
                ['payment_token',$payment_token],
                ['payment_status','Unpaid']
                ])->take(1)->get();
        foreach($get_details as $detail){
            $price = $detail->total_price;
            $serial = $detail->serial;
        }
        $converted = ceil((string)$price*100);
        $description = 'Order payment  bill on - '.$serial;
        $token = $this->stripe->tokens->create([
                'card' => [
                    'number' => $card_number,
                    'exp_month' => $month,
                    'exp_year' => $year,
                    'cvc' => $cvc
                ]
            ]);
        $charge = $this->stripe->charges->create([
                'amount' => $converted,
                'currency' => 'usd',
                'source' => $token,
                'description' => $description
            ]);
         if($charge){
            Order::where([
                ['payment_token',$payment_token],
                ['payment_status','Unpaid']
                ])->update([
                    'payment_status' => 'Paid',
                    'updated_at' => Carbon::now()
                ]);
            return redirect()->route('view.invoice',['token'=>$payment_token]);
         }else{
            return redirect()->back()->with('payement_error','Sorry we could not process your payment');
         }
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }
    public function SubmitAppointment(Request $req){
        if(Session::get('path') === 'User'){
             $validator = $req->validate([
               'patient_name' => 'required|max:255',
               'patient_age' => 'required|numeric',
            ]);
            $client_serial = Session::get('serial');
            $doctor = $req->doctor;
            $patient_name = $req->patient_name;
            $patient_age = $req->patient_age;
            $visiting_day = $req->visiting_day;
            $appointment_serial = IDGen::generate(['table' => 'doctor_appointments', 'field' => 'serial', 'length' => 10, 'prefix' => 'da-']);
            DoctorAppointment::insert([
                'serial' => $appointment_serial,
                'patient_name' => $patient_name,
                'patient_age' => $patient_age,
                'visiting_day' => $visiting_day,
                'doctor' => $doctor,
                'client_id' => $client_serial,
                'created_at' => Carbon::now()
            ]);
            return redirect()->route('user.dashboard');
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }
}
