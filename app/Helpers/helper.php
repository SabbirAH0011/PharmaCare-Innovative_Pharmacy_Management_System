<?php

namespace App\Helpers;
use Illuminate\Support\Str;
use Carbon\Carbon;

class helper{
    /* App access token generate */
    public static function AppAccessToken(){
        $time_stamp =  str_replace(' ', '',Carbon::now());
        $random_sting_gen = Str::random(40).uniqid();
        $access_token = md5($time_stamp.$random_sting_gen);
        return $access_token;
    }
}
