<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


/**
 * * Modelo Vehículo
 */
class Vehicle extends Model
{
   
    protected $guarded = []; 

    public function user() {
        return $this->belongsTo(User::class);
    }
}