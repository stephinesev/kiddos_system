<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'name',
        'email',
        'birth_date',
        'gender',
        'address',
        'role',
        'weight',
        'height',
        'bmi',
        'status',
        'barangay',
        'school_name',
        'grade_level',
        'student_id',
        'guardian_name',
        'guardian_contact_no',
        'guardian_relationship',
        'nutritional_status',
        'delete_bmi',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function bmi_history(){
        return $this->hasMany(BmiHistory::class, 'beneficiary_id');
    }
}
