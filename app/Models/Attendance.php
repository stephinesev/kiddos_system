<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $table="attendance";
    protected $fillable=[
        'beneficiary_id',
        'attendance_date',
        'user_id'
    ];
}
