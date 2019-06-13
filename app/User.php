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
        'password'=>'required|max:8|min:6',
        'url' => 'required|url'

        ]);
        if ($validator->fails()) {
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
        return static::where('first_name', $user);
    }
    public static function allUser()
    {
        return static::get()->toArray();
    }
    public static function countUser()
    {
        return static::count();
    }

    public static function saveUser($user_data)
    {
        return static::create($user_data);
    }

    public static function validateWithFeatureTest($data)
    {
        $messages = [
        'email.email' => 'Email format is incorrect!',
        'email.required' => 'Please enter your email address',
        'email.unique'=>'Email address has already been used to register. Please use another email address',
        'password.required' => 'Please enter your password',
        'password.max' => 'password should not be greater than 8 characters',
        'password.min' => 'password should not be less than 6 characters',
        'confirm_password.required' => 'Please confirm your password',
        'confirm_password.same'=>'Confirm password should be same as password'
      ];
        $validator = Validator::make($data, [
        'email' => 'email|required|unique:users,email',
        'first_name'=>'unique:users',
        'password'=>'required|max:8|min:6',
        'confirm_password'=>'required|same:password'
        ], $messages);
        if ($validator->fails()) {
            return response()->json(['success'=>false], 400);
        }
        return response()->json(['success'=>true], 200);
    }
}
