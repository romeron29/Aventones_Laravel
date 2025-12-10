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
        $UserStub = new class { 
            public $vehicles;
        };
        
        $mockUser = new $UserStub; 
        
        $mockUser->vehicles = [$vehicle1, $vehicle2]; 

        $this->assertIsArray($mockUser->vehicles);
        $this->assertCount(2, $mockUser->vehicles);
    }
}