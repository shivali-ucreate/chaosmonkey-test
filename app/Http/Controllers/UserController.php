<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Redirect;
use App\User;
use Auth;

class UserController extends Controller
{
    public function register()
    {
        return view('register');
    }
    public function registerUser(Request $request)
    {
        $user_data = $request->all();
        $messages = [
        'email.email' => 'Email format is incorrect!',
        'email.required' => 'Please enter your email address',
        'first_name.required'=>'Please enter your name',
        'email.unique'=>'Email address has already been used to register. Please use another email address',
        'password.required' => 'Please enter your password',
        'password.max' => 'password should not be greater than 8 characters',
        'password.min' => 'password should not be less than 6 characters',
        'confirm_password.required' => 'Please confirm your password',
        'confirm_password.same'=>'Confirm password should be same as password'
      ];
        $validator = Validator::make($user_data, [
        'email' => 'email|required|unique:users,email',
        'first_name'=>'unique:users|required',
        'password'=>'required|max:8|min:6',
        'confirm_password'=>'required|same:password'
        ], $messages);
        if ($validator->fails()) {
            return redirect('/register')->withErrors($validator->errors())->withInput();
        }
        $user = User::saveUser($user_data);
        return $user;
    }

    public function login()
    {
        return view('login');
    }

    public function loginUser(Request $request)
    {
        $user_data = $request->all();
        $messages = [
        'email.email' => 'Email format is incorrect!',
        'email.required' => 'Please enter your email address',
        'password.required' => 'Please enter your password'
      ];
        $validator = Validator::make($user_data, [
        'email' => 'email|required',
        'password'=>'required'
        ], $messages);
        if ($validator->fails()) {
            return redirect('/login')->withErrors($validator->errors())->withInput();
        } else {
            $user = User::selectUser('email', $user_data['email']);

            if (Auth::loginUsingId($user)) {
                return redirect('/home');
            }
        }
    }

    public function doLogout()
    {
        Auth::logout();
        return Redirect::to('login');
    }
}
