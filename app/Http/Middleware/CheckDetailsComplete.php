<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\UserAdminEmployeeAccess;
use Carbon\Carbon;
use Session;

class CheckDetailsComplete
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
        $get_user_details =UserAdminEmployeeAccess::where([
        ['email','=',$user_email],
        ['access_token','=',$user_access_token],
        ['time_limit','>=',Carbon::now()],
        ['status','=','Active']
        ])
        ->get();
        foreach($get_user_details as $user){
          $name = $user->name;
          $phone = $user->phone;
          $path = $user->path;
        }
        if((!empty($name))&&(!empty($phone))){
            return $next($request);
        }else{
            return redirect()->route('account.details');
        }
    }
}
