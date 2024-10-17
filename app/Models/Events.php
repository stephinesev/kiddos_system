<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    use HasFactory;
    protected $table = "events";
    protected $fillable = [
        'event_name',
        'event_description',
        'event_address',
        'barangay',
        'barangay_name',
        'event_time',
        'start_date',
        'end_date',
        'event_color',
    ];
}
