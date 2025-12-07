<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;


/**
 * * Modelo Usuario 
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'lastname', 'cedula', 'birthdate', 'email', 
        'phone', 'photo_path', 'role', 'status', 'password',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Relaciones
    public function vehicles() {
        return $this->hasMany(Vehicle::class);
    }

    public function rides() {
        return $this->hasMany(Ride::class);
    }

    public function reservations() {
        return $this->hasMany(Reservation::class);
    }
}