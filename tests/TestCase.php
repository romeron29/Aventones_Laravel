<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as FakerFactory;

use Faker\Provider\en_US\Person; // << Nuevo: Importa el proveedor de personas

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function setUp(): void
    {
        parent::setUp();
        
        // 🛑 Modifica la inicialización de Faker:
        $faker = FakerFactory::create('en_US');
        
        // 🛑 NUEVO: Agrega explícitamente el proveedor de nombres (Person)
        $faker->addProvider(new Person($faker)); 
        
        $this->faker = $faker;
    }
}


