<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * * Modelo Viaje (Ride)
 */
class Ride extends Model
{
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class); 
    }

    public function vehicle() {
        return $this->belongsTo(Vehicle::class); 
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }
}