<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckLocationBeforeBooking
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $set_location = $request->location;
        if(!empty($set_location)){
            return $next($request);
        }else{
            return redirect()->route('select.location_for_booking',['required'=>'Please select your location first']);
        }
    }
}
