<?php

namespace App\Http\Controllers;

use App\User;
use App\Raspberry;
use App\Raspberry_Access;
use Auth;
use App\Http\Controllers\Controller;
use \DateTime;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class NewRaspController extends Controller
{
	/**
     * Show the application registration of new raspberry form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showNewRaspForm()
    {
        return view('auth.newRasp');
    }
	
	 /**
     * Handle a registration for a new raspberry for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function registerNewRasp(Request $request)
    {
		$this->validator($request->all())->validate();
		$ip = $request->input('ip_address');
		if (Raspberry::where('ip_address', $ip)->count() == 0) 
		{
			Raspberry::create([
				'ip_address' => $request->input('ip_address')
			]);
		}
		$raspberryID = Raspberry::where('ip_address', $ip)->value('id');
		$userID = Auth::id();
		$duplicateRaspberry = 	Raspberry_Access::where('user_id', $userID)
								->where('raspberry_id', $raspberryID)
								->first();
		
		if ($duplicateRaspberry === null) 
		{
			Raspberry_Access::create([
				'user_id' => $userID,
				'raspberry_id' => $raspberryID
			]);
			$raspberry_message = "";
		}
		else 
		{
			$raspberry_message = $ip;
		}
		return redirect()	->route('home')
							->with('raspberry_message', $raspberry_message);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'ip_address' => 'required|string|min:7|max:15',
        ]);
    }

}