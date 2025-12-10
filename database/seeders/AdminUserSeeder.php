<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        if (!User::where('email', 'proyectos.uni.02@gmail.com')->exists()) {
            User::create([
                'name' => 'admin',
                'lastname' => 'principal', 
                'cedula' => '7749479849645',
                'birthdate' => Carbon::parse('2002-06-29'), 
                'phone' => '95294469',
                'email' => 'proyectos.uni.02@gmail.com', 
                'password' => Hash::make('123456'), 
                'role' => 'admin', 
                'status' => 'activo', 
            ]);
            echo "Usuario Administrador creado con éxito.\n";
        } else {
             echo "El usuario Administrador ya existe. No se creó nada.\n";
        }
    }
}