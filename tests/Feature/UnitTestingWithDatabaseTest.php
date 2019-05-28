<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\ParentTestClass;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Components\QueryComponent;
use App\User;
use App\Products;
use App\UserProductOrder;
use App\Http\Controllers\UserController;
class UnitTestingWithDatabaseTest extends TestCase
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


    /***************Create a test to see if the user get successfully created in the users table.*******************/
    
    public function testCreateUser()
    {
        
        $user = factory(User::class)->create();
        $this->assertInstanceOf(User::class, $user);
    }

    
    /********Create a test to verify the validation error of incorrect email while creating user.*********/
    public function testUserEmail(){
        $user = ['first_name'=>'shivali',
        'last_name'=>'sharma',
        'email'=>'shivali@ucreate',
        'password'=>'admin123'
        ];
        $this->assertArrayHasKey('email', $user);
        $result = User::validate($user);
        $email_error_message = array_shift($result['email']);
    	$this->assertEquals('The email must be a valid email address.', $email_error_message);
    }
    /********Save user data*********/
    public function testUserSave(){
        $user = ['first_name'=>'shivali',
        'last_name'=>'sharma',
        'email'=>'shivali@ucreate.co.in',
        'password'=>'admin123'
        ];
        $this->assertArrayHasKey('email', $user);
        $result = User::validate($user);
        $save_user = User::saveUserData($user);
        return $save_user;
    }
    /*******************Similar to the task 2, more validation need to be added like name to be unique, password should be minumum 6 and maximum 8 characters.**************/
    public function testUserNameAndPassword(){
        $user = ['first_name'=>'shivali',
        'last_name'=>'sharma',
        'email'=>'shivali@ucreate.co.in',
        'password'=>'admin'
        ];
        $this->assertArrayHasKey('first_name', $user);
        $this->assertArrayHasKey('password', $user);
        $result = User::validate($user);
        $name_error_message = array_shift($result['first_name']);
        $this->assertEquals('The first name has already been taken.', $name_error_message);
        $password_error_message = array_shift($result['password']);
        $this->assertEquals('The password must be at least 6 characters.', $password_error_message);
    }
    /*******Create a test that used the output of other test as it's input.********/
    /**
     * @depends testUserSave
     */
    public function testProductSave($save_user){
        $product = ['user_id'=>$save_user,
        'product_name'=>'tsunami'
        ];
        $this->assertArrayHasKey('product_name', $product);
        $save_product = Products::saveProductData($product);
        $this->assertTrue(True);
        return $save_product;
    }
    /**************Create a test to see if we can have it's dependency on 2 tests.***************/
     /**
     * @depends testUserSave
     * @depends testProductSave
     */
     public function testProductOrder($save_user,$save_product){
        $order = ['user_id'=>$save_user,
        'product_id'=>$save_product,
        'quantity'=>20
        ];
        $this->assertEquals('12',$save_user);
        $this->assertEquals('1',$save_product);
        $save_order = UserProductOrder::saveUserProductOrder($order);
        $this->assertTrue(True);
    }
    
  /*******Create a test to validate url with regular expression.******/
    /**
     * @dataProvider provider
     */

    public function testCheckUrl($url,$regex,$expected)
    {
        $this->assertEquals($expected,preg_match($regex, $url));
        
    }

    public function provider()
    {
    	 $regex = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
         return [
            ['https://www.google.com', $regex, true],
            ['https://gggg', $regex, false],
            ['https://google??gghg', $regex, false]
        ];
    }

   /****Create a test that have assertCount($count, $array) assertion in it.****/
    public function testCount(){
        $user_array = User::allUser();
        $user_count = User::countUser();
        $this->assertCount($user_count,$user_array);
    }
}
