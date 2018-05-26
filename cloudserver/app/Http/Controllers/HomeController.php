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
		$raspberry_and_device_state = 1 Show notice message (no Raspberry Pis)
		$raspberry_and_device_state = 2 Show only devices
		$raspberry_and_device_state = 3 Show notice message (no devices) and different Raspberry Pis
		$raspberry_and_device_state = 4 Show devices and different Raspberry Pis
		*/
		$user_id = Auth::id();
		$raspberries = self::userRaspberries($user_id);
		$new_raspberry_message = session('new_raspberry_message');
		if ($new_raspberry_message === null)
		{
			$new_raspberry_message = "";
		} 
		if (session('ip_address') !== null) 
		{
			$ip_address = session('ip_address');
		}
		else
		{
			$ip_address = "";
		}
		if (count($raspberries) === 0)
		{
			$raspberry_and_device_state = 1;
			return 	view('/home')
					->with('raspberry_and_device_state', $raspberry_and_device_state);
		}
		else if  (count($raspberries) === 1) 
		{
			$raspberry_and_device_state = 2;
			$raspberry = $raspberries[0];
			$ip_address = $raspberry->ip_address;
			$decided_raspberry_id = $raspberry->id;
			$user_devices = self::userDevices($user_id, $decided_raspberry_id);
			list($device_names, $id_in_residences) = self::getNameAndResidenceID($user_devices);
			return 	view('/home')
					->with('device_names', $device_names)
					->with('id_in_residences', $id_in_residences)
					->with('this_ip', $ip_address)
					->with('raspberry_and_device_state', $raspberry_and_device_state)
					->with('new_raspberry_message', $new_raspberry_message);
		} 
		else if  (count($raspberries) > 1)  
		{
			$raspberry_and_device_state = 3;
			$ip_addresses = self::getIP_Addresses($raspberries);
			return 	view('/home')
					->with('ip_addresses', $ip_addresses)
					->with('this_ip', $ip_address)
					->with('raspberry_and_device_state', $raspberry_and_device_state)
					->with('new_raspberry_message', $new_raspberry_message);
		}
    }
	
	/**
	 * Show the devices for the decided Raspberry Pis
	 * 
	 * @param \Illuminate\Http\Request  $request Store the ip-address for the chosen raspberry
	 * @return \Illuminate\Http\Response The devices the user have access to on this raspberry
	 */
	public function getDevicesWithSeveralRaspberries(Request $request)
	{
		$raspberry_and_device_state = 4;
		$user_id = Auth::id();
		$ip_address = $request->input('ip_address');
		$raspberries = self::userRaspberries($user_id);
		$decided_raspberry_id = Raspberry::where('ip_address', $ip_address)->value('id');
		$user_devices = self::userDevices($user_id, $decided_raspberry_id);
		$ip_addresses = self::getIP_Addresses($raspberries);
		list($device_names, $id_in_residences) = self::getNameAndResidenceID($user_devices);
		return 	view('/home')
				->with('device_names', $device_names)
				->with('id_in_residences', $id_in_residences)
				->with('ip_addresses', $ip_addresses)
				->with('this_ip', $ip_address)
				->with('raspberry_and_device_state', $raspberry_and_device_state);
	}
	
	/**
	 * To use the function right use list($device_names, $id_in_residences) = self::getNameAndResidenceID($user_devices);
	 * to call method. 
	 *
	 * @param user_devices The devices the user has
	 * @return $device_names and $id_in_residences
	 *
	 */
	private function getNameAndResidenceID($user_devices) //severalRasps
	{
		$device_names = array();
		$id_in_residences = array();
		foreach ($user_devices as $user_device) 
		{	
			$device_names[] =	$user_device->device_name;
			$id_in_residences[] = $user_device->id_in_residence;
		}
		return array($device_names, $id_in_residences);
	}
	
	/**
	 * Get the IP-addresses of an array of Raspberry objects
	 *
	 * @param raspberries An array of Raspberry objects
	 * @return ip_addresses int[] 
	 * 
	 */
	private function getIP_Addresses($raspberries) {
		$ip_addresses = array();
		foreach ($raspberries as $raspberry) 
		{	
			$ip_addresses[] =	$raspberry->ip_address;
		}
		return $ip_addresses;
	}
	
	/**
	 * Get the user's devices on this Raspberry Pi
	 *
	 * @param $user_id The id of the user
	 * @param $decided_raspberry_id The id of the current Raspberry Pi
	 * @return $user_devices The user's devices on current Raspberry Pi
	 *
	 */
	private function userDevices($user_id, $decided_raspberry_id)
	{
		$device_accesses = Device_Access::where('user_id', $user_id)->get();
		$user_devices = array();
		foreach ($device_accesses as $device_access) 
		{	
			$device =	Device::where('id', $device_access->device_id)
						->where('raspberry_id', $decided_raspberry_id)
						->first();
			//If a user has access to devices but not the raspberry
			if ($device !== null)
			{
				$user_devices[] = $device;
			}
		}
		return $user_devices;
	}
	
	/**
	 * Get the user's raspberries
	 * 
	 * @param $user_id The user's id in the database
	 * @return This user's raspberries from the database
	 */
	private function userRaspberries($user_id)
	{
		$user_rasp_accesses = Raspberry_Access::where('user_id', $user_id)->get();
		$raspberries = array();
		foreach ($user_rasp_accesses as $user_rasp_access) 
		{
			$raspberries[] = Raspberry::find($user_rasp_access->raspberry_id);
		}
		return $raspberries;
	}
}
