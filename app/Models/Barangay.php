<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barangay extends Model
{
    use HasFactory;
    protected $table='barangay';
    protected $fillable=[
        'barangay_name',
        'city'
    ];
}
