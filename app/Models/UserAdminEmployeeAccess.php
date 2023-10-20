<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAdminEmployeeAccess extends Model
{
    use HasFactory;
    protected $fillable = [
        'serial',
        'name',
        'phone',
        'email',
        'access_token',
        'time_limit',
        'otp',
        'path',
        'status'
    ];
}
