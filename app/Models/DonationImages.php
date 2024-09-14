<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonationImages extends Model
{
    use HasFactory;
    protected $table = "donation_images";
    protected $fillable = [
        'donation_id',
        'image_name'
    ];
    public function donations(){
        return $this->hasMany(Donations::class, 'donation_id');
    }
}
