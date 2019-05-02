<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChaosMonkey extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testTrue()
    {
        $this->assertTrue(true);
    }

    public function testFalse()
    {
        $this->assertFalse(false);
    }

    public function testName()
    {

        $this->assertTrue(true);
        $user = ['name'=>'shivali'];
        $this->assertEquals($user,['name'=>'shivali']);
    }
    
}
