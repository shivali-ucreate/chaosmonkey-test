<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

/*Auth::routes();*/

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/test', 'HomeController@test')->name('test');
Route::get('/register', 'UserController@register')->name('register');
Route::post('/register_user', 'UserController@registerUser');
Route::get('/login', 'UserController@login')->name('login');
Route::post('/login_user', 'UserController@loginUser');
Route::get('/logout', 'UserController@doLogout');
