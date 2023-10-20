<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VendorStore;
use App\Models\MedicineList;
use App\Models\Manufacturar;
use App\Models\Doctor;
use App\Models\BloodBank;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Session;

class PageController extends Controller
{
    public function WelcomePage(){
        $verify_vendor_patner = VendorStore::where('status','Approved')->exists();
        $fetch_store = VendorStore::where('status','Approved')->orderBy('serial','DESC')->take(3)->get();
        $verify_primary_care = MedicineList::where([
            ['drug_category','Primary-care'],
            ['total_stock','>', 0]
            ])->exists();
        $fetch_primary_care =DB::table('medicine_lists')
        ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
        ->where([
            ['medicine_lists.drug_category','=','Primary-care'],
            ['medicine_lists.total_stock','>', 0],
            ['vendor_stores.status','=','Approved']
            ])
        ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address')
        ->orderBy('medicine_lists.serial','DESC')
        ->take(5)
        ->get();
        $verify_mother_and_baby = MedicineList::where([
            ['drug_category','Mother-and-baby'],
            ['total_stock','>', 0]
            ])->exists();
        $fetch_mother_and_baby =DB::table('medicine_lists')
        ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
        ->where([
            ['medicine_lists.drug_category','=','Mother-and-baby'],
            ['medicine_lists.total_stock','>', 0],
            ['vendor_stores.status','=','Approved']
            ])
        ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address')
        ->orderBy('medicine_lists.serial','DESC')
        ->take(5)
        ->get();
        $verify_supplements_and_vitamins = MedicineList::where([
            ['drug_category','Supplements-and-vitamins'],
            ['total_stock','>', 0]
            ])->exists();
        $fetch_verify_supplements_and_vitamins =DB::table('medicine_lists')
        ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
        ->where([
            ['medicine_lists.drug_category','=','Supplements-and-vitamins'],
            ['medicine_lists.total_stock','>', 0],
            ['vendor_stores.status','=','Approved']
            ])
        ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address')
        ->orderBy('medicine_lists.serial','DESC')
        ->take(5)
        ->get();
        $verify_personal_care = MedicineList::where([
            ['drug_category','Personal-care'],
            ['total_stock','>', 0]
            ])->exists();
        $fetch_personal_care =DB::table('medicine_lists')
        ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
        ->where([
            ['medicine_lists.drug_category','=','Personal-care'],
            ['medicine_lists.total_stock','>', 0],
            ['vendor_stores.status','=','Approved']
            ])
        ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address')
        ->orderBy('medicine_lists.serial','DESC')
        ->take(5)
        ->get();
        return view('frontend.web.pages.index',
        compact('verify_vendor_patner','fetch_store','verify_primary_care','fetch_primary_care',
        'verify_mother_and_baby','fetch_mother_and_baby','verify_supplements_and_vitamins','fetch_verify_supplements_and_vitamins',
        'verify_personal_care','fetch_personal_care'));
    }

    public function EDA(){
        return view('frontend.web.pages.eda');
    }

    public function ProductList(Request $req){
        $product_name = $req->name;
        $category_name = $req->category;
        $user_location = Session::get('user_location');
        $validated_manufacturer = MedicineList::where('manufacturer','LIKE',"%$product_name%")->exists();
        if(!empty($product_name)){
            if($validated_manufacturer === true){
                $fetch_product = DB::table('medicine_lists')
                ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                ->where([
                   ['medicine_lists.manufacturer','LIKE',"%$product_name%"],
                   ['medicine_lists.total_stock','>', 0],
                   ['vendor_stores.zone','=',$user_location],
                ])
                ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address')
                ->orderBy('medicine_lists.serial','DESC')
                ->paginate(10);
                $total_count =  DB::table('medicine_lists')
                ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                 ->where([
                 ['medicine_lists.manufacturer','=',$product_name],
                 ['total_stock','>', 0],
                 ['vendor_stores.zone','=',$user_location],
                ])->count();
            }else{
                $fetch_product = DB::table('medicine_lists')
                ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                ->where([
                   ['medicine_lists.medicine_name','LIKE',"%$product_name%"],
                   ['medicine_lists.total_stock','>', 0],
                   ['vendor_stores.zone','=',$user_location],
                ])
                ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address')
                ->orderBy('medicine_lists.serial','DESC')
                ->paginate(10);
                $total_count =  DB::table('medicine_lists')
                 ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                 ->where([
                 ['medicine_lists.manufacturer','=',$product_name],
                 ['total_stock','>', 0],
                 ['vendor_stores.zone','=',$user_location],
                ])->count();
            }
        }elseif($category_name) {
            $fetch_product = DB::table('medicine_lists')
                ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                ->where([
                   ['medicine_lists.drug_category','=',$category_name],
                   ['medicine_lists.total_stock','>', 0],
                   ['vendor_stores.zone','=',$user_location],
                ])
                ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address')
                ->orderBy('medicine_lists.serial','DESC')
                ->paginate(10);
            $total_count = DB::table('medicine_lists')
                 ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                 ->where([
                   ['drug_category','=',$category_name],
                   ['total_stock','>', 0],
                   ['vendor_stores.zone','=',$user_location],
                ])->count();
        }else{
            $fetch_product = DB::table('medicine_lists')
                ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                ->where([
                    ['medicine_lists.total_stock','>', 0],
                    ['vendor_stores.zone','=',$user_location],
                ])
                ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address')
                ->orderBy('medicine_lists.serial','DESC')
                ->paginate(10);
            $total_count = DB::table('medicine_lists')
                 ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                 ->where([
                   ['drug_category','=',$category_name],
                   ['total_stock','>', 0],
                   ['vendor_stores.zone','=',$user_location],
                ])->count();
        }
        $fetch_manufacturer =  Manufacturar::all();
       return view('frontend.web.pages.product_list',compact('fetch_product','total_count','fetch_manufacturer'));
    }

    public function FetchSearchProduct(Request $req){
        $search_element = $req->search_element;
        $user_location = Session::get('user_location');
        $validated_manufacturer = MedicineList::where('manufacturer','LIKE',"%$search_element%")->exists();
        if(!empty($search_element)){
            if($validated_manufacturer === true){
               $fetch_product = DB::table('medicine_lists')
                ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                ->where([
                   ['medicine_lists.manufacturer','LIKE',"%$search_element%"],
                   ['medicine_lists.total_stock','>', 0],
                   ['vendor_stores.zone','=',$user_location],
                ])
                ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address')
                ->limit(20)
                ->get();
                $verify_data = DB::table('medicine_lists')
                 ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                 ->where([
                   ['medicine_lists.manufacturer','LIKE',"%$search_element%"],
                   ['total_stock','>', 0],
                   ['vendor_stores.zone','=',$user_location],
                ])->exists();
            }else{
                $fetch_product = DB::table('medicine_lists')
                ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                ->where([
                   ['medicine_lists.medicine_name','LIKE',"%$search_element%"],
                   ['medicine_lists.total_stock','>', 0],
                   ['vendor_stores.zone','=',$user_location],
                ])
                ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address')
                ->limit(20)
                ->get();
                $verify_data = DB::table('medicine_lists')
                 ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                 ->where([
                   ['medicine_lists.medicine_name','LIKE',"%$search_element%"],
                   ['total_stock','>', 0],
                   ['vendor_stores.zone','=',$user_location],
                ])->exists();
            }
            if(($verify_data === true) && (!empty($user_location))){
                 return response()->json([
                        'status'=>'Accepted',
                        'query' =>'exists',
                        'html' => view('frontend.web.pages.page-chunks.search-result',compact('fetch_product'))->render()
                    ],200);
            }else{
                return response()->json([
                        'status'=>'Accepted',
                        'query' =>'not exists'
                    ],200);
            }
        }else{
            return response()->json([
                        'status'=>'Accepted',
                        'query' =>'not exists'
                    ],200);
        }
    }

    public function ProductDetails(Request $req){
        $producr_id = $req->producr_id;
        $user_location = Session::get('user_location');
        $validate_availability = DB::table('medicine_lists')
               ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
               ->where([
                  ['medicine_lists.serial','=',$producr_id],
                  ['medicine_lists.total_stock','>', 0],
                  ['vendor_stores.zone','=',$user_location],
               ])->exists();
        if($validate_availability === true){
            $fetch_product_details = DB::table('medicine_lists')
               ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
               ->where([
                  ['medicine_lists.serial','=',$producr_id],
                  ['medicine_lists.total_stock','>', 0],
                  ['vendor_stores.zone','=',$user_location],
               ])
               ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address',
               'vendor_stores.phone','vendor_stores.zone')
               ->get();
             foreach($fetch_product_details as $product_detail){
                 $zone = $product_detail->zone;
             }
             if($zone == $user_location){
                 $all_product = DB::table('medicine_lists')
                    ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                        ->where([
                         ['medicine_lists.total_stock','>', 0],
                         ['vendor_stores.zone','=',$user_location],
                         ])
                        ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address',
                        'vendor_stores.phone','vendor_stores.zone')
                        ->orderBy('medicine_lists.serial','DESC')
                        ->take(10)
                        ->get();
                 foreach ($fetch_product_details as $product_details) {
                     $store_id = $product_details->store_id;
                 }
                 $vendor_store = DB::table('medicine_lists')
                        ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
                        ->where([
                           ['medicine_lists.store_id','=',$store_id],
                           ['medicine_lists.total_stock','>', 0],
                           ['vendor_stores.zone','=',$user_location],
                        ])
                        ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address',
                        'vendor_stores.phone','vendor_stores.zone')
                        ->take(5)
                        ->get();
                 return view('frontend.web.pages.product_detail',compact('fetch_product_details','all_product','vendor_store'));
             }else{
                 return  new Response(view('errors.204'));
             }
        }else{
             return  new Response(view('errors.204'));
        }
    }

    public function VedorShop(Request $req){
        $shop_id = $req->shop_id;
        $validate_existance = MedicineList::where('medicine_lists.store_id','=',$shop_id)->exists();
        if($validate_existance === true){
            $vendor_store = DB::table('medicine_lists')
               ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
               ->where([
                  ['medicine_lists.store_id','=',$shop_id],
                  ['medicine_lists.total_stock','>', 0]
               ])
               ->select('medicine_lists.*','vendor_stores.store_name','vendor_stores.address',
               'vendor_stores.phone','vendor_stores.zone')
               ->orderBy('medicine_lists.serial','DESC')
               ->paginate(10);
            $total_count = DB::table('medicine_lists')
               ->join('vendor_stores','medicine_lists.store_id','vendor_stores.serial')
               ->where([
                  ['medicine_lists.store_id','=',$shop_id],
                  ['medicine_lists.total_stock','>', 0]
               ])
               ->count();
            foreach ($vendor_store as $store) {
                $store_name = $store->store_name;
                $address = $store->address;
                $phone = $store->phone;
            }
            return view('frontend.web.pages.vendor_shop',compact('vendor_store','total_count','store_name','address','phone'));
        }else{
             return  new Response(view('errors.404'));
        }
    }

    public function VendorList(){
        $vendor_store = VendorStore::where('status','Approved')->paginate(10);
        $total_count = VendorStore::where('status','Approved')->count();
        return view('frontend.web.pages.vendor_list',compact('vendor_store','total_count'));
    }

    public function BloodBank(){
        $fetch_blood_list = BloodBank::orderBy('group','ASC')->paginate(20);
         return view('frontend.web.pages.blood-bank',compact('fetch_blood_list'));
    }

    public function FindDoctor(Request $req){
        $doctor_search = $req->doctor_search;
        if(!empty($doctor_search)){
            $doctors = DB::table('doctors')
            ->orWhere('name','Like',"%$doctor_search%")
            ->orWhere('degree','Like',"%$doctor_search%")
            ->orWhere('speciality','Like',"%$doctor_search%")
            ->paginate(10);
        }else{
            $doctors = Doctor::paginate(10);
        }
        $total_count = Doctor::count();
        return view('frontend.web.pages.doctor_list',compact('doctors','total_count'));
    }

    public function GetAppointment(Request $req){
        $doctor_serial = $req->serial;
        $doctors = Doctor::where('serial',$doctor_serial)->paginate(10);
        return view('frontend.web.pages.doctor_appointment',compact('doctors'));
    }
}
