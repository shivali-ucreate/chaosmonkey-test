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
            'first_name' => 'sh',
            'last_name'=>'sharma',
            'email' => 'shivali12@ucreate.co.in',
            'password'=>'test123',
            'confirm_password' => 'test123'
        ];

        $this->login_data = [
            'email' => 'shivali12@ucreate.co.in',
            'password'=>'test123'
        ];
    }

    public function testCreateUser()
    {
        $data = $this->post('/register_user', $this->user_data);
        $this->assertTrue(true);
    }

    public function testLogin()
    {
        $response = $this->get('/login');
        $response->assertSee("login here");
        $response->assertStatus(200);
    }

    public function testDoLoginWithAuth()
    {
        $user = factory(User::class)->create([
            'id' => random_int(1, 100),
            'password' => bcrypt($password = 'hello'),
        ]);
        
        $response = $this->actingAs($user)->post('/login_user', [
            'email' => $user->email,
            'password' => $password,
            'remember' => 'on',
            ]);
        
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function testDoLoginWithWrongEmail()
    {
        $this->login_data['email']='abc';
        $data = $this->post('/login_user', $this->login_data);
        $data->assertRedirect('/login');
        $data->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function testDoLoginWithoutPassword()
    {
        $this->login_data['password']='';
        $data = $this->post('/login_user', $this->login_data);
        $data->assertRedirect('/login');
        $data->assertSessionHasErrors('password');
        $this->assertGuest();
    }

    public function testDoLogin()
    {
        $data = $this->post('/login_user', $this->login_data);
        $data->assertRedirect('/home');
    }

    

    public function testDoLogout()
    {
        $data = $this->get('/logout');
        $data->assertRedirect('/login');
    }
}
