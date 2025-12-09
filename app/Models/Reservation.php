<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
/**
 * * Modelo Reserva (Reservation)
 */
class Reservation extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user() {
        return $this->belongsTo(User::class); 
    }

    public function ride() {
        return $this->belongsTo(Ride::class); 
    }
}