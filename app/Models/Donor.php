<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    use HasFactory;
    protected $table = "donors";
    protected $fillable = [
        'fullname',
        'birth_date',
        'password',
        'gender',
        'address',
        'email',
        'contact_no',
    ];
}
