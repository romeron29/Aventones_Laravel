<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * * Modelo Viaje (Ride)
 */
class Ride extends Model
{
    use HasFactory;
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
    public function isAvailable(): bool
    {
        return $this->seats_available > 0;
    }
}