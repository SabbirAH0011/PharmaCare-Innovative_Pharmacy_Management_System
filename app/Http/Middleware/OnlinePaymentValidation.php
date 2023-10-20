<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Order;

class OnlinePaymentValidation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $payment_token = $request->payment_token;
        if(empty($payment_token)){
            return  new Response(view('errors.403'));
        }else{
            $varify_payment = Order::where([
                ['payment_token',$payment_token],
                ['payment_status','Unpaid']
                ])->exists();
                if($varify_payment === true){
                    return $next($request);
                }else{
                    return  new Response(view('errors.403'));
                }
        }
    }
}
