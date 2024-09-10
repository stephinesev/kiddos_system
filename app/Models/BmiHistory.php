<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BmiHistory extends Model
{
    use HasFactory;
    protected $table = "bmi_history";
    protected $fillable = [
        'beneficiary_id',
        'weight',
        'height',
        'bmi',
        'nutritional_status',
        'bmi_date', 
    ];
}
