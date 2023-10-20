<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorOrderSerial extends Model
{
    use HasFactory;
    protected $fillable = [
        'order_serial',
        'store_serial'
    ];
}
