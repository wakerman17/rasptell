<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use App\Raspberry_Access;
use App\Raspberry;
use App\Device_Access;
use App\Device;
use App\User;

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
     * Show the application index and send information about how many raspberries the user have.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
		/*
		$flag = 1 Show only devices
		$flag = 2 Show notice message (no rasps)
		$flag = 3 Show notice message (no devices) and different rasps
		$flag = 4 Show devices and different rasps
		*/
		$userID = Auth::id();
		$raspberries = self::userRasps ($userID);
		$raspberry_message = session('raspberry_message');
		if ($raspberry_message === null)
		{
			$raspberry_message = "";
		} 
		if (session('ip') !== null) 
		{
			$ip = session('ip');
		}
		else
		{
			$ip = 0;
		}
		if (count($raspberries) === 1)
		{
			$flag = 1;
			$raspberry = $raspberries[0];
			$user_accesses = 	Device_Access::where('user_id', $userID)->get();
			$user_devices = array();
			foreach ($user_accesses as $user_access) 
			{
					
				$device =	Device::where('id', $user_access->device_id)
							->where('raspberry_id', $raspberry->id)
							->first();
				//If a user has access to devices but not the raspberry
				if ($device !== null)
				{
					$user_devices[] = $device;
				}
			}
			
			return 	view('/home')
					->with('user_devices', $user_devices)
					->with('ip', $raspberry->ip_address)
					->with('flag', $flag)
					->with('raspberry_message', $raspberry_message);
		}
		if  (count($raspberries) === 0) 
		{
			$flag = 2;
			return 	view('/home')
					->with('flag', $flag)
					->with('raspberry_message', $raspberry_message);
		} if  (count($raspberries) > 1)  {
			$flag = 3;
			return 	view('/home')
					->with('raspberries', $raspberries)
					->with('ip', $ip)
					->with('flag', $flag)
					->with('raspberry_message', $raspberry_message);
		}
    }
	
	/**
	 * Show the devices for the decided raspberry
	 * 
	 * @param \Illuminate\Http\Request  $request Store the ip-address for the choosen raspberry
	 * @return \Illuminate\Http\Response The devices the user have access to on this raspberry
	 */
	public function severalRasps(Request $request)
	{
		$flag = 4;
		$userID = Auth::id();
		$ip = $request->input('ip_address');
		$raspberries = self::userRasps($userID);
		$device_accesses = Device_Access::where('user_id', $userID)->get();
		$decided_raspberryID = Raspberry::where('ip_address', $ip)->value('id');
		$user_devices = array();
		//with all accesses to the devices and the ID of the decided raspberry, the code checks if the raspberry is
		//assigned to the current device
		foreach ($device_accesses as $device_access) 
		{
			$device = 	Device::where('id', $device_access->device_id)
						->where('raspberry_id', $decided_raspberryID)
						->first();
			if ($device !== null)
			{
				$user_devices[] = $device;
			}
		}
		
		return 	view('/home')
				->with('raspberries', $raspberries)
				->with('user_devices', $user_devices)
				->with('ip', $ip)
				->with('flag', $flag);
	}
	
	/**
	 * Get the user's raspberries
	 * 
	 * @param $userID The user's id in the database
	 * @return This user's raspberries from the database
	 */
	private function userRasps ($userID)
	{
		$user_rasp_accesses = Raspberry_Access::where('user_id', $userID)->get();
		$raspberries = array();
		foreach ($user_rasp_accesses as $user_rasp_access) 
		{
			$raspberries[] = Raspberry::find($user_rasp_access->raspberry_id);
		}
		return $raspberries;
	}
}