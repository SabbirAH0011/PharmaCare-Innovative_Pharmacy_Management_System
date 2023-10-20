<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\Models\Location;
use App\Models\VendorStore;
use App\Models\Manufacturar;
use App\Models\MedicineList;
use App\Models\DrugCategory;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use Carbon\Carbon;

class VendorController extends Controller
{
    public function ViewVendorDashboard(){
        if(Session::get('path') === 'Vendor'){
            $fetch_zone = Location::all();
            $fetch_store = VendorStore::where('owner',Session::get('serial'))->paginate(10);
            return view('auth.dashboard.vendors.dashboard',compact('fetch_zone','fetch_store'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function MedicineList(Request $req){
        if(Session::get('path') === 'Vendor'){
            $store = $req->store;
            $fetch_manufacturar = Manufacturar::all();
            $fetch_drug_category = DrugCategory::all();
            $fetch_medicine = MedicineList::where('store_id',$store)->paginate(10);
            return view('auth.dashboard.vendors.list_medicine',compact('fetch_manufacturar','fetch_medicine','fetch_drug_category'));
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function RegisterStore(Request $req){
        if(Session::get('path') === 'Vendor'){
            $validator = $req->validate([
               'shope_name' => 'required|max:255',
               'shop_address' => 'required',
               'phone' => 'required|numeric|digits:11',
            ]);
            $shope_name = $req->shope_name;
            $shop_address = $req->shop_address;
            $phone = $req->phone;
            $zone = $req->zone;
            $serial = IdGenerator::generate(['table' => 'vendor_stores', 'field' => 'serial', 'length' => 10, 'prefix' => 'str-']);
            $insert_store = VendorStore::insert([
                'serial' => $serial,
                'store_name' => Str::upper($shope_name),
                'address' => $shop_address,
                'phone' => $phone,
                'zone' => $zone,
                'owner' => Session::get('serial'),
                'created_at' => Carbon::now()
            ]);
            if($insert_store){
                return redirect()->back()->with(['store_success' => 'Store saved']);
            }else{
                return redirect()->back()->withErrors(['store_error' => 'Could not save store']);
            }
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function StoreListMedicineINVendor(Request $req){
        if(Session::get('path') === 'Vendor'){
            $validator = $req->validate([
               'main_image' => 'required|mimes:jpg,jpeg,png,webp|max:2048',
               'medicine_name' => 'required|max:255',
               'medicine_type' => 'required|max:255',
               'drug_category' => 'required|max:255',
               'total_stock' => 'required|numeric',
               'price' => 'required|numeric',
               'description' => 'required|max:1000',
               'manufacturer' => 'required|max:255',
           ]);
           $main_image=$req->main_image;
           $medicine_name=$req->medicine_name;
           $medicine_type=$req->medicine_type;
           $drug_category=$req->drug_category;
           $total_stock=$req->total_stock;
           $price = $req->price;
           $description=$req->description;
           $manufacturer=$req->manufacturer;
           $store_id=$req->store_id;
           $serial = IdGenerator::generate(['table' => 'medicine_lists', 'field' => 'serial', 'length' => 10, 'prefix' => 'ml-']);
           $validate_manufacturar = Manufacturar::where('name',$manufacturer)->exists();
           if($validate_manufacturar === false){
            Manufacturar::insert([
             'name' => $manufacturer,
             'created_at' => Carbon::now()
            ]);
           }
           $validate_product = MedicineList::where([
            ['medicine_name',$medicine_name],
            ['store_id',$store_id]
            ])->exists();
           if($validate_product === true){
            $fetch_medicine_name=MedicineList::where('medicine_name',$medicine_name)->get();
            foreach ($fetch_medicine_name as $medicine) {
                $existing_stock = $medicine->total_stock;
            }
            $final_stock = $existing_stock+$total_stock;
            MedicineList::where('medicine_name',$medicine_name)->update([
                'total_stock' => $final_stock,
                'updated_at' => Carbon::now()
            ]);
           }else{
            $file_name_gen = hexdec(uniqid()).'.'. $main_image->getClientOriginalExtension();
            Image::make($main_image)->resize(400,400)->save('public/assets/img/medicine/'.$file_name_gen);
            $final_image = '/public/assets/img/medicine/'.$file_name_gen;
            MedicineList::insert([
                'serial' => $serial,
                'main_image' => $final_image,
                'medicine_name' => $medicine_name,
                'medicine_type' => $medicine_type,
                'drug_category' => $drug_category,
                'total_stock' => $total_stock,
                'price' => $price,
                'description' => $description,
                'manufacturer' => $manufacturer,
                'store_id' => $store_id,
                'created_at' => Carbon::now()
            ]);
           }
           return redirect()->back()->with(['medicine_success' => 'Medicine saved']);
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }

    public function UpdateListMedicineINVendor(Request $req){
        if(Session::get('path') === 'Vendor'){
            $validator = $req->validate([
               'medicine_name' => 'required|max:255',
               'medicine_type' => 'required|max:255',
               'drug_category' => 'required|max:255',
               'total_stock' => 'required|numeric',
               'price' => 'required|numeric',
               'description' => 'required|max:1000',
               'manufacturer' => 'required|max:255',
           ]);
           $medicine_name=$req->medicine_name;
           $medicine_type=$req->medicine_type;
           $drug_category=$req->drug_category;
           $total_stock=$req->total_stock;
           $price = $req->price;
           $description=$req->description;
           $manufacturer=$req->manufacturer;
           $medicine_id=$req->medicine_id;
           MedicineList::where('serial',$medicine_id)->update([
                   'medicine_name' => $medicine_name,
                   'medicine_type' => $medicine_type,
                   'drug_category' => $drug_category,
                   'total_stock' => $total_stock,
                   'price' => $price,
                   'description' => $description,
                   'manufacturer' => $manufacturer,
                   'updated_at' => Carbon::now()
               ]);
           return redirect()->back()->with(['medicine_success' => 'Medicine updated']);
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
    }
}
