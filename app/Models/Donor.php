<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Donor extends Authenticatable
{
    // use HasFactory;
    use HasApiTokens, HasFactory, Notifiable;
    protected $guard = 'donor';
    protected $table = "donors";
    protected $fillable = [
        'fullname',
        'birth_date',
        'password',
        'gender',
        'address',
        'email',
        'contact_no',
        'profile_image',
    ];
    protected $hidden = [
        // 'password',
        'remember_token',
    ];
    protected $casts = [
        'password' => 'hashed',
    ];
}
