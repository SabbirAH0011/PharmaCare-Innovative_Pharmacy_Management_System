<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookedAmbulance extends Model
{
    use HasFactory;
    protected $fillable = [
        'location',
        'address',
        'destination',
        'total',
        'total_payment_status',
        'partial',
        'partial_payment_status',
        'ambulance_no',
        'booked_by',
        'status'
    ];
}
