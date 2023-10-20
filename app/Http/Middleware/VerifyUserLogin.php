<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;

class VerifyUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if((session()->has('access_token'))&&(session()->get('path') !== 'Admin')){
            return $next($request);
        }else{
                Session::flush();
                return redirect()->route('get.otp');
            }
    }
}
