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
        'barangay',
        'donation_type', 
        'mode_of_collection', 
        'pickup_description', 
        'status', 
    ];
}
