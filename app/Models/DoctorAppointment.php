<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DoctorAppointment extends Model
{
    use HasFactory;
    protected $fillable = [
        'patient_name',
        'patient_age',
        'visiting_day',
        'doctor',
        'client_id',
        'status',
    ];
}
