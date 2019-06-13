<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Redirect;
use App\User;

class UserController extends Controller
{
    public function register()
    {
        return view('register');
        return 200;
    }
    public function registerUser(Request $request)
    {
        $user_data = $request->all();
        $result = User::validateWithFeatureTest($user_data);
        return $result;
    }
}
