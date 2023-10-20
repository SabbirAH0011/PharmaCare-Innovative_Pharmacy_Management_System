<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicineList extends Model
{
    use HasFactory;
     protected $fillable = [
        'main_image',
        'medicine_name',
        'medicine_type',
        'drug_category',
        'total_stock',
        'price',
        'description',
        'manufacturer',
        'store_id',
    ];
}
