<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserAdminEmployeeAccess;
use App\Helpers\helper;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Exception;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use Session;

class LoginAccessController extends Controller
{
    public function GetOTPView(){
        return view('auth.login-verify.get_otp');
    }

    public function GetVerify(Request $req){
        try{
            $email = $req->email;
            $access_token = helper::AppAccessToken();
            $serial = IdGenerator::generate(['table' => 'user_admin_employee_accesses', 'field' => 'serial', 'length' => 10, 'prefix' => 'pc-']);
            $otp = rand(1001,9999);
            if(empty($email)){
                return response()->json([
                  'status' => false,
                  'error' => 'yes',
                  'msg' => 'Please input your email'
                 ],200);
            }else{
                $validation_existance = UserAdminEmployeeAccess::where('email',$email)->exists();
                if($validation_existance === true){
                    $inset_update_user = UserAdminEmployeeAccess::where('email', $email)
                    ->update([
                        'access_token' => $access_token,
                        'time_limit' => Carbon::now()->addDays(365),
                        'otp' => $otp,
                        'updated_at' => Carbon::now()
                    ]);
                }else{
                    $inset_update_user = UserAdminEmployeeAccess::insert([
                        'serial' => $serial,
                        'email' => $email,
                        'access_token' => $access_token,
                        'time_limit' => Carbon::now()->addDays(365),
                        'otp' => $otp,
                        'path' => 'User',
                        'created_at' => Carbon::now()
                    ]);
                }
                if($inset_update_user){
                    $text = 'হ্যালো আপনার অটিপিটি হল -';
                    $data=[
                          'text'=> $text,
                          'otp'=>$otp
                      ];
                    $user['to']= $email;
                      Mail::send('emails.otp',$data,function($mail)use($user){
                           $mail->to($user['to']);
                           $mail->subject('OTP - Pharma Check ['.date("l jS \of F Y").']');
                          });
                    return response()->json([
                      'status' => true,
                      'error' => 'no',
                      'url' => route('set.otp',['email' => $email])
                    ],200);
                }else{
                    return response()->json([
                      'status' => false,
                      'error' => 'yes',
                      'msg' => 'Something went wrong please contact with the admin'
                    ],200);
                }
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

    public function SetOTPView(){
        return view('auth.login-verify.set_otp');
    }

    public function OTPVerify(Request $req){
        $validator = $req->validate([
               'email' => 'required',
               'otp' => 'required|numeric|digits:4',
           ]);
        $email = $req->email;
        $otp = $req->otp;
        $verify_user = UserAdminEmployeeAccess::where([
            ['email', $email],
            ['otp', $otp]
            ])
        ->exists();
        if($verify_user === true){
            $fetch_credential = UserAdminEmployeeAccess::where([
              ['email', $email],
              ['otp', $otp]
              ])
              ->take(1)
              ->get();
              foreach($fetch_credential as $user){
                Session::put([
                    'serial' => $user->serial,
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'access_token' => $user->access_token,
                    'path' => $user->path,
                ]);
                $path = $user->path;
              }
            $update_credential = UserAdminEmployeeAccess::where([
              ['email', $email],
              ['otp', $otp]
              ])
              ->update([
                'otp' => 0,
                'updated_at' => Carbon::now()
              ]);
            if($update_credential){
                if($path === 'Admin'){
                    return redirect()->route('admin.dashboard');
                }elseif($path === 'User'){
                    return redirect()->route('user.dashboard');
                }elseif($path === 'Ambulance-driver'){
                    return redirect()->route('ambulance.dashboard');
                }elseif($path === 'Vendor'){
                    return redirect()->route('vendor.dashboard');
                }elseif($path === 'Rider'){
                   return redirect()->route('rider.dashboard');
                }else{
                    return  new Response(view('errors.403'));
                }
            }else{
                return redirect()->back()->withErrors(['error' => 'Your credentials did not matched']);
            }
        }else{
            return redirect()->back()->withErrors(['error' => 'Your credentials did not matched']);
        }
    }
}
