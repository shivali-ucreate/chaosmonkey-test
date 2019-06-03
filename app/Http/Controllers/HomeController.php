<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\TestMonologJob;
use Carbon\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        dispatch(new TestMonologJob())->delay(Carbon::now()->addSeconds(3));
    }
}
