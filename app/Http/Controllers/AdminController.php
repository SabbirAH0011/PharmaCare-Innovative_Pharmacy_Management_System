<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Exception;
use App\Models\Location;
use App\Models\DrugCategory;
use App\Models\UserAdminEmployeeAccess;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Models\Ambulance;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Models\VendorStore;
use App\Models\RiderLocation;
use App\Models\BloodBank;
use App\Models\Order;
use App\Models\Doctor;
use App\Models\DoctorAppointment;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function ViewAdminDashboard(){
        if(Session::get('path') === 'Admin'){
            $get_booking_details = DB::table('booked_ambulances')
            ->join('ambulances','booked_ambulances.ambulance_no','ambulances.serial')
            ->join('user_admin_employee_accesses','ambulances.driver_serial','user_admin_employee_accesses.serial')
            ->select('booked_ambulances.*','user_admin_employee_accesses.name','user_admin_employee_accesses.phone',
            'ambulances.number_plate','ambulances.type')
            ->orderBy('booked_ambulances.serial','DESC')
            ->get();
            $get_vendor_store = DB::table('vendor_stores')
            ->join('user_admin_employee_accesses','vendor_stores.owner','user_admin_employee_accesses.serial')
            ->select('vendor_stores.*','user_admin_employee_accesses.name','user_admin_employee_accesses.phone As owner_phone','user_admin_employee_accesses.email')
            ->paginate(10);
            $get_oder_details = DB::table('orders')
            ->leftJoin('user_admin_employee_accesses','orders.client_serial','user_admin_employee_accesses.serial')
            ->select('orders.*','user_admin_employee_accesses.name As client_name','user_admin_employee_accesses.phone As client_phone')
            ->orderBy('orders.serial','DESC')->paginate(2);
            return view('auth.dashboard.admin.dashboard',compact('get_booking_details','get_vendor_store','get_oder_details'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function Logout(){
        Session::flush();
        return redirect()->route('welcome');
    }

    public function StoreLocation(Request $req){
        try{
            $location = Str::ucfirst($req->location);
            $verify_location = Location::where('zone',$location)->exists();
            if($verify_location === true){
                return response()->json([
                      'status' => false,
                      'error' => 'yes',
                      'msg' => $location.' is already registered as zone'
                    ],200);
            }else{
                $store_location = Location::insert([
                    'zone' => $location,
                    'created_at' => Carbon::now()
                ]);
                return response()->json([
                      'status' => true,
                      'error' => 'no',
                      'msg' => $location.' saved as new zone'
                    ],200);
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

    public function StoreCategory(Request $req){
        $validator = $req->validate([
               'category' => 'required|max:255',
           ]);
        $category = Str::ucfirst(Str::slug($req->category, '-'));
        $is_top = $req->is_top;
        if(!empty($is_top)){
            $final_category_decision = $is_top;
        }else{
            $final_category_decision = 'no';
        }
        $verify_category = DrugCategory::where('category',$category)->exists();
        if($verify_category === true){
           return redirect()->back()->withErrors(['error' => 'Category already exists']);
        }else{
            $store_category = DrugCategory::insert([
                'category' => $category,
                'is_top' => $final_category_decision,
                'created_at' => Carbon::now()
            ]);
            if($store_category === true){
               return redirect()->back()->with(['success' => 'Category inserted successfully']);
            }else{
               return redirect()->back()->withErrors(['error' => 'Could not insert category']);
            }
        }
    }

    public function ViewAmbulanceTable(){
        if(Session::get('path') === 'Admin'){
            $fetch_zone = Location::all();
            $fetch_driver = UserAdminEmployeeAccess::where('path','Ambulance-driver')->get();
            $get_ambulance = DB::table('ambulances')
            ->join('user_admin_employee_accesses','ambulances.driver_serial','user_admin_employee_accesses.serial')
            ->select('ambulances.*','user_admin_employee_accesses.name','user_admin_employee_accesses.phone')
            ->paginate(10);
            return view('auth.dashboard.admin.ambulance_table',compact('fetch_zone','fetch_driver','get_ambulance'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function StoreAmbulanceBooking(Request $req){
        if(Session::get('path') === 'Admin'){
            $validator = $req->validate([
               'number_plate' => 'required|max:255|unique:ambulances,number_plate',
               'ambulance_type' => 'required|max:255',
               'price' => 'required|numeric|min:1000',
               'main_image' => 'mimes:jpg,jpeg,png|max:2048',
            ]);
            $number_plate = $req->number_plate;
            $ambulance_type = $req->ambulance_type;
            $zone = $req->zone;
            $driver = $req->driver;
            $price = $req->price;
            $main_image = $req->main_image;
            $serial = IdGenerator::generate(['table' => 'ambulances', 'field' => 'serial', 'length' => 10, 'prefix' => 'amb-']);
            if(!empty($main_image)){
                $file_name_gen = hexdec(uniqid()).'.'. $main_image->getClientOriginalExtension();
                Image::make($main_image)->resize(400,400)->save('public/assets/img/ambulance/'.$file_name_gen);
                $final_car_image = '/public/assets/img/ambulance/'.$file_name_gen;
            }else{
                $final_car_image = NULL;
            }
            $insert_ambulance = Ambulance::insert([
                'serial' => $serial,
                'image' => $final_car_image,
                'number_plate' => $number_plate,
                'type' => $ambulance_type,
                'zone' => $zone,
                'driver_serial' => $driver,
                'price' => $price,
                'created_at' => Carbon::now()
            ]);
            if($insert_ambulance){
                return redirect()->back()->with(['success' => 'Ambulance saved']);
            }else{
                return redirect()->back()->withErrors(['error' => 'Could not save ambulance']);
            }
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function AmbulanceDriverRiderReg(){
        if(Session::get('path') === 'Admin'){
            $get_user_details = UserAdminEmployeeAccess::where('path','!=','Admin')->orderBy('serial','DESC')
            ->paginate(10);
            $get_rider_details = DB::table('user_admin_employee_accesses')
            ->join('rider_locations','user_admin_employee_accesses.serial','rider_locations.user_serial')
            ->where('user_admin_employee_accesses.path','=','Rider')
            ->select('user_admin_employee_accesses.*','rider_locations.location')
            ->orderBy('user_admin_employee_accesses.serial','DESC')
            ->get();
            $fetch_zone = Location::all();
            return view('auth.dashboard.admin.ambulance-driver-rider',compact('get_user_details','get_rider_details','fetch_zone'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function ChangeStatusUser(Request $req){
        $serial = $req->serial;
        $change_path = $req->change_path;
        UserAdminEmployeeAccess::where('serial',$serial)->update([
            'path' => $change_path,
            'updated_at' => Carbon::now()
        ]);
        if($change_path === 'Rider'){
            RiderLocation::insert([
                'user_serial' => $serial,
                'updated_at' => Carbon::now()
            ]);
        }
        return redirect()->route('admbulance.driver_rider');
    }

    public function ChangeStatusVendorStore(Request $req){
        $serial = $req->serial;
        $email = $req->email;
        $owner = $req->owner;
        $store_name = $req->store_name;
        $location = $req->zone;
        $change_permission = $req->change_permission;
        $update_status = VendorStore::where('serial',$serial)->update([
            'status' => $change_permission,
            'updated_at' => Carbon::now()
        ]);
        if($update_status){
             $text = 'হ্যালো আপনার ভেন্ডর স্টোরের  স্টেটাস চেঞ্জ করা হয়েছে  -';
             $data=[
                  'text'=> $text,
                  'store_name'=>$store_name,
                  'location'=>$location,
                  'status' => $change_permission
              ];
            $user['to']= $email;
              Mail::send('emails.change_status_vendor',$data,function($mail)use($user){
                   $mail->to($user['to']);
                   $mail->subject('Vendor store status change - Pharma Check ['.date("l jS \of F Y").']');
                  });
        }
        return redirect()->route('admin.dashboard');
    }
    public function ChangeRiderLoctiaon(Request $req){
        $serial = $req->serial;
        $location = $req->location;
         RiderLocation::where('user_serial',$serial,)->update([
                'location' => $location,
                'updated_at' => Carbon::now()
            ]);
        return redirect()->back();
    }

    public function RemoveRequest(Request $req){
        if(Session::get('path') === 'Admin'){
            $serial = $req->serial;
            Order::where('serial',$serial)->delete();
            return redirect()->back();
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function BloodDonationReg(){
        if(Session::get('path') === 'Admin'){
            $fetch_blood_list = BloodBank::orderBy('group','ASC')->paginate(20);
            return view('auth.dashboard.admin.blood-donation-reg',compact('fetch_blood_list'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function StoreBloodDonationReg(Request $req){
        if(Session::get('path') === 'Admin'){
            $validator = $req->validate([
               'donor_contact' => 'required|numeric|digits:11',
           ]);
           $blood_group = str_replace(' ','',$req->blood_group);
           $bag = $req->bag;
           $donor_name = $req->donor_name;
           $donor_contact = $req->donor_contact;
           $donor_collection = collect();
           $validate_blood = BloodBank::where('group',$blood_group)->exists();
           if($validate_blood === true){
            $get_datail = BloodBank::where('group',$blood_group)->take(1)->get();
            foreach ($get_datail as $detail) {
                $donor_details_collection = json_decode($detail->doners,true);
            }

            foreach ($donor_details_collection as $key => $donor) {
            $donor_collection->push([
             'donor_name' => $donor['donor_name'],
             'donor_contact' => $donor['donor_contact'],
             ]);
            }
            $donor_collection->push([
                'donor_name' => $donor_name,
                'donor_contact' => $donor_contact,
            ]);
            BloodBank::where('group',$blood_group)->update([
                'doners' => json_encode($donor_collection),
                'bag' => DB::raw('bag + ' . $bag),
                'created_at' => Carbon::now()
            ]);
           }else{
            $donor_collection->push([
                'donor_name' => $donor_name,
                'donor_contact' => $donor_contact,
            ]);
            BloodBank::insert([
                'group' => $blood_group,
                'doners' => json_encode($donor_collection),
                'bag' => $bag,
                'created_at' => Carbon::now()
            ]);
           }
           return redirect()->back();
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function RegisterDoctor(){
        if(Session::get('path') === 'Admin'){
            $get_appointment = DB::table('doctor_appointments')
            ->join('doctors','doctor_appointments.doctor','doctors.serial')
            ->select('doctor_appointments.*','doctors.name','doctors.degree','doctors.speciality','doctors.hospital',
            'doctors.time')
            ->paginate(10);
            $doctors = Doctor::paginate(10);
            return view('auth.dashboard.admin.doctor-reg',compact('doctors','get_appointment'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function StoreDoctor(Request $req){
        if(Session::get('path') === 'Admin'){
           $validator = $req->validate([
               'name' => 'required|max:255|unique:doctors,name',
               'degree' => 'required|max:255',
               'speciality' => 'required|max:255',
               'hospital' => 'required|max:255',
               'from_time' => 'required|max:255',
               'to_time' => 'required|max:255',
               'day.*' => 'required|max:255',
               'main_image' => 'mimes:jpg,jpeg,png|max:2048',
            ]);
            $name = $req->name;
            $degree = $req->degree;
            $speciality = $req->speciality;
            $hospital = $req->hospital;
            $from_time = $req->from_time;
            $to_time = $req->to_time;
            $day = $req->day;
            $main_image = $req->main_image;
            $serial = IdGenerator::generate(['table' => 'doctors', 'field' => 'serial', 'length' => 10, 'prefix' => 'dr-']);
            if(!empty($main_image)){
                $file_name_gen = hexdec(uniqid()).'.'. $main_image->getClientOriginalExtension();
                Image::make($main_image)->resize(400,400)->save('public/assets/img/doctors/'.$file_name_gen);
                $final_car_image = '/public/assets/img/doctors/'.$file_name_gen;
            }else{
                $final_car_image = NULL;
            }
            $day_data = collect();
            for($i = 0; $i < count($day); $i++){
                $day_data->push([
                    "day" => $day[$i]
                ]);
            }
            Doctor::insert([
                'serial' => $serial,
                'image' => $final_car_image,
                'name' => $name,
                'degree' => $degree,
                'speciality' => $speciality,
                'hospital' => $hospital,
                'time' => $from_time.' to '.$to_time,
                'day' => json_encode($day_data),
                'created_at' => Carbon::now()
            ]);
            return redirect()->back()->with('success_doctor','Doctor registered successfully');
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function ChangeAppointmentStatus(Request $req){
        $serial = $req->serial;
        $status = $req->status;
        DoctorAppointment::where('serial','=',$serial)->update([
            'status'=>$status,
            'updated_at' => Carbon::now()
            ]);
        return redirect()->back();
    }
}
