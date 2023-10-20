<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use App\Models\UserAdminEmployeeAccess;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class LoginCheckAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user_email = Session::get('email');
        $user_access_token = Session::get('access_token');

        if((empty($user_email))&&(empty($user_access_token))){
            return $next($request);
        }else{
            $verify_user_token = UserAdminEmployeeAccess::where([
                ['email','=',$user_email],
                ['access_token','=',$user_access_token],
                ['time_limit','>=',Carbon::now()],
                ['status','=','Active']
                ])
            ->exists();
            if($verify_user_token === true){
                $fetch_path = UserAdminEmployeeAccess::where([
                  ['email','=',$user_email],
                  ['access_token','=',$user_access_token],
                  ['status','=','Active']
                  ])
                ->get();
                foreach ($fetch_path as $path_data) {
                    $path = $path_data->path;
                }
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
                Session::flush();
                return redirect()->route('get.otp');
            }
        }
    }
}
