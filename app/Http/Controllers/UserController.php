<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Validator;
use Redirect;
class UserController extends Controller
{
    public static function userCreate($array){
    	$form_data = $array;
            if (isset($form_data['email']) && !empty($form_data['email'])) {
                $form_data['email'] = strtolower($form_data['email']);
            }
        $messages = [
        'email.email' => 'Email format is incorrect!',
        'email.required' => 'Please enter your email address',
        'password.required' => 'Please enter your password'
      ];
        $validator= Validator::make($form_data, [
        'email' => 'email|required',
        'password' => 'Required'
      ], $messages);
            if ($validator->fails()) {
            return false;
        }
    }
}
