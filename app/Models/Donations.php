<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donations extends Model
{
    use HasFactory;
    protected $fillable = [
        'donor_id',
        'event_id',
        'when_date',
        'when_time',
        'event_address',
        'barangay',
        'barangay_name',
        'donation_type', 
        'mode_of_collection', 
        'pickup_description', 
        'pickup_contact_no', 
        'status', 
        'others', 
    ];
    public function events(){
        return $this->belongsTo(Events::class,'event_id', 'id');
    }
}
