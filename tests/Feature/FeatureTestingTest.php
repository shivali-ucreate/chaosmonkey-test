<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\ParentTestClass;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Components\QueryComponent;
use App\User;
use App\Http\Controllers\UserController;

class FeatureTestingTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */

    public function setUp(): void
    {
        parent::setUp();
        $this->user_data = [
            'first_name' => 'tanav',
            'last_name'=>'sharma',
            'email' => 'shivalisharma12@ucreate.co.in',
            'password'=>'test123',
            'confirm_password' => 'test123'
        ];
    }


    public function testBasicTest()
    {
        $response = $this->get('/');
        $response->assertSee("Hello Ucreate");
        $response->assertStatus(200);
    }

    public function testRegister()
    {
        $response = $this->get('/register');
        $response->assertSee("Register");
        $response->assertStatus(200);
    }

    public function testUniqueEmail()
    {
        $this->user_data['email'] = 'shivali@ucreate.co.in';
        $data = $this->post('/register_user', $this->user_data);
        $data->assertStatus(400);
    }

    public function testConfirmPassword()
    {
        $this->user_data['confirm_password'] = 'test9999';
        $data = $this->post('/register_user', $this->user_data);
        $data->assertStatus(400);
    }

    public function testCreateUser()
    {
        $data = $this->post('/register_user', $this->user_data);
        $data->assertSee("success");
        $data->assertStatus(200);
    }
}
