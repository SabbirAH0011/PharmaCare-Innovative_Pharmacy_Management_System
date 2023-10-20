<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'client_serial',
        'product_detail_group',
        'shipping_address',
        'total_price',
        'deilvery_charge',
        'total_amount',
        'payment_method',
        'payment_token',
        'payment_status',
        'location',
        'delivery_status',
        'rider_serial',
    ];
}
