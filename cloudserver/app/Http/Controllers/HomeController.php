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
		/*
		$flag = 1 Show only devices
		$flag = 2 Show error message (no rasps)
		$flag = 3 Show error message (no devices) and different rasps
		$flag = 4 Show devices and different rasps
		*/
		$user = DB::table('user')
				->where('name', Auth::user()->name)
				->where('email', Auth::user()->email)
				->first();
		$raspberrys = 	DB::table('raspberry_for_user')
						->where('user_id', $user->id)
						->get();
		$rasp = array();
		foreach ($raspberrys as $raspberry) {
			$rasp[] = 	DB::table('raspberry')
						->where('id', $raspberry->raspberry_id)
						->first();
			}
		if (count($rasp) === 1)
		{
			//Show only devices
			$flag = 1;
			$user_accesses = 	DB::table('access')
								->where('user_id', $user->id)
								->get();
			$user_devices = array();
		
			foreach ($user_accesses as $user_access) {
			$user_devices[] = 	DB::table('device')
								->where('id', $user_access->device_id)
								->where('raspberry_id', $rasp[0]->id)
								->first();
			}
			return 	view('/home')
					->with('user_devices', $user_devices)
					->with('ip', $rasp[0]->ip_address)
					->with('flag', $flag);
		} 
		if  (count($rasp) === 0) 
		{
			//Show error message
			$flag = 2;
			return 	view('/home')
					->with('flag', $flag);
		} if  (count($rasp) > 1)  {
			//Show error message and different rasps
			$flag = 3;
			$user_rasp_accesses = array();
			foreach ($raspberrys as $raspberry) {
			$user_rasp_accesses[] = 	DB::table('raspberry')
									->where('id', $raspberry->raspberry_id)
									->first();
			}
			return 	view('/home')
					->with('user_rasp_accesses', $user_rasp_accesses)
					->with('flag', $flag)
					->with('rasp', $rasp);
		}
    }
	
	public function severalRasps(Request $request)
	{
		//Show devices and different rasps
		$flag = 4;
		//this user
		$user = DB::table('user')
				->where('name', Auth::user()->name)
				->Where('email', Auth::user()->email)
				->first();
		//this users all rasp access
		$raspberrys = 	DB::table('raspberry_for_user')
						->where('user_id', $user->id)
						->get();
		$user_rasp_accesses = array();
		//this users all rasps
		foreach ($raspberrys as $raspberry) {
			$user_rasp_accesses[] = 	DB::table('raspberry')
										->where('id', $raspberry->raspberry_id)
										->first();
		}
		//decided rasp's
		$my_rasps = array();
		foreach ($user_rasp_accesses as $user_rasp_access) {
			$my_rasps[] = 	DB::table('raspberry')
							->where('id', $user_rasp_access->id)
							->where('ip_address', $request->input('ip_address'))
							->first();
		}
		//this user's all device access
		$user_accesses = 	DB::table('access')
							->where('user_id', $user->id)
							->get();
		$user_devices = array();
		//the devices
		foreach ($user_accesses as $user_access) {
			foreach ($my_rasps as $my_rasp) {
				if ($my_rasp == null) 
				{
					continue;
				}
				
				$user_devices[] = 	DB::table('device')
									->where('id', $user_access->device_id)
									->where('raspberry_id', $my_rasp->id)
									->first();
			}
		}
		$user_devices = array_filter($user_devices);
		return 	view('/home')
				->with('user_rasp_accesses', $user_rasp_accesses)
				->with('user_devices', $user_devices)
				->with('ip', $request->input('ip_address'))
				->with('flag', $flag);
	}
}
