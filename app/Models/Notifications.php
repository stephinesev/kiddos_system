<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = "notification";
    protected $fillable = [
        'beneficiary_id',
        'donor_id',
        'donation_id',
        'event_id',
        'notification',
        'read',
        'identifier'
    ];
    public function donors(){
        return $this->hasMany(Donor::class, 'id', 'donor_id');
    }

    public function users(){
        return $this->hasMany(User::class, 'id', 'beneficiary_id');
    }
}
