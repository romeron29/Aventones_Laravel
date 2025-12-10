<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Faker\Factory as FakerFactory;

use Faker\Provider\en_US\Person;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    protected function setUp(): void
    {
        parent::setUp();
        
        $faker = FakerFactory::create('en_US');
        
        $faker->addProvider(new Person($faker)); 
        
        $this->faker = $faker;
    }
}


