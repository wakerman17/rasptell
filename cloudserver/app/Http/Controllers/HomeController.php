<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

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
		$user = DB::table('users')
				->where('name', Auth::user()->name)
				->Where('email', Auth::user()->email)
				->first();
		$ip = 	DB::table('raspberry')
				->where('id', $user->id)
				->value('ip_address');
		$user_accesses = 	DB::table('access')
							->where('user_id', $user->id)
							->get();
		
		$user_devices = array();
		
		foreach ($user_accesses as $user_access) {
		$user_devices[] = DB::table('device')
						->where('id', $user_access->device_id)
						->first();
		}
		return 	view('/home')
				->with('user_devices', $user_devices)
				->with('ip', $ip);
        //return view('home');
    }
}
