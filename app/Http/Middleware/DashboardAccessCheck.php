<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use App\Models\UserAdminEmployeeAccess;
use Carbon\Carbon;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\HttpFoundation\Response;

class DashboardAccessCheck
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
        if((!empty($user_email))&&(!empty($user_access_token))){
            $verify_user_token = UserAdminEmployeeAccess::where([
                ['email','=',$user_email],
                ['access_token','=',$user_access_token],
                ['time_limit','>=',Carbon::now()],
                ['status','=','Active']
                ])
            ->exists();
            if($verify_user_token === true){
               return $next($request);
        }else{
            Session::flush();
            return redirect()->route('get.otp');
        }
      }else{
        Session::flush();
        return redirect()->route('get.otp');
      }
    }
}
