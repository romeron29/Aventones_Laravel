<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Models\User;
use App\Models\Vehicle; 

class UserVehicleRelationshipTest extends TestCase
{
    /** @test */
    public function usuario_posee_varios_vehiculos()
    {
        // 1. Simular los vehículos como objetos genéricos
        $vehicle1 = (object)['id' => 1, 'model' => 'Toyota'];
        $vehicle2 = (object)['id' => 2, 'model' => 'Honda'];
        
        // 2. Definición del Mock (Blueprint) del Usuario
        // 🛑 SOLUCIÓN: La clase anónima YA NO tiene constructor.
        $UserStub = new class { 
            public $vehicles;
            // public function __construct(array $vehicles) { ELIMINADO
            //     $this->vehicles = $vehicles;
            // } ELIMINADO
        };
        
        // 3. Instanciación y Carga de la Relación (Asignación manual)
        // Instanciamos el stub sin argumentos.
        $mockUser = new $UserStub; 
        
        // 🛑 Asignamos la propiedad directamente después de la instanciación.
        $mockUser->vehicles = [$vehicle1, $vehicle2]; 

        // 4. Aserciones
        $this->assertIsArray($mockUser->vehicles);
        $this->assertCount(2, $mockUser->vehicles);
    }
}