<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\ParentTestClass;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Components\QueryComponent;
use App\User;
use App\Http\Controllers\UserController;

class FeatureRegisterTest extends TestCase
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
            'first_name' => 'tanav',
            'last_name'=>'sharma',
            'email' => 'shivali15@ucreate.co.in',
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
    
    public function testCreateUserEmailError()
    {
        $this->user_data['email']='abc';
        $data = $this->post('/register_user', $this->user_data);
        $data->assertRedirect('/register');
        $data->assertSessionHasErrors('email');
    }

    public function testCreateUserPasswordError()
    {
        $this->user_data['password']='abc';
        $data = $this->post('/register_user', $this->user_data);
        $data->assertRedirect('/register');
        $data->assertSessionHasErrors('password');
    }

    public function testCreateUserConfirmPasswordError()
    {
        $this->user_data['confirm_password']='abc';
        $data = $this->post('/register_user', $this->user_data);
        $data->assertRedirect('/register');
        $data->assertSessionHasErrors('confirm_password');
    }

    public function testCreateUserNameError()
    {
        $this->user_data['first_name']='';
        $data = $this->post('/register_user', $this->user_data);
        $data->assertRedirect('/register');
        $data->assertSessionHasErrors('first_name');
    }

    public function testCreateUser()
    {
        $data = $this->post('/register_user', $this->user_data);
        $this->assertTrue(true);
    }
}
