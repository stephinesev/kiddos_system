<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = "notification";
    protected $fillable = [
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
}
