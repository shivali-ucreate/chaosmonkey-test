<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Validator;
class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $errors;

    public static function validate($data)
    {
        $validator = Validator::make($data, [
	    'email' => 'email|required',
	    'first_name'=>'unique:users',
	    'password'=>'required|max:8|min:6'

    	]);
        if ($validator->fails())
        {
           return $validator->errors()->toArray();
        }
        return true;
    }

    public static function saveUserData($user_data)
    {
        $user =  static::create($user_data);
        return $user->id;
    }
    public static function selectUser($user)
    {
        return static::where('first_name',$user);
    }
    public static function allUser()
    {
        return static::get()->toArray();
    }
    public static function countUser()
    {
        return static::count();
    }
    
}
