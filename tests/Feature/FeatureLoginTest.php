<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\ParentTestClass;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Components\QueryComponent;
use App\User;
use App\Http\Controllers\UserController;

class FeatureLoginTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public static function setUpBeforeClass()
    {
        exec('php artisan migrate:refresh');
        exec('php artisan db:seed');
    }

    public function setUp(): void
    {
        parent::setUp();
        $this->user_data = [
            'email' => 'shivali@ucreate.co.in',
            'password'=>'admin123'
        ];
    }

    public function testLogin()
    {
        $response = $this->get('/login');
        $response->assertSee("login here");
        $response->assertStatus(200);
    }
    
}
