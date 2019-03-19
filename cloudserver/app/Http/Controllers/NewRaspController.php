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
		$ip_address = $request->input('ip_address');
		if (Raspberry::where('ip_address', $ip_address)->count() == 0) 
		{
			Raspberry::create([
				'ip_address' => $request->input('ip_address')
			]);
		}
		$raspberry_id = Raspberry::where('ip_address', $ip_address)->value('id');
		$user_id = Auth::id();
		$duplicateRaspberry = 	Raspberry_Access::where('user_id', $user_id)
								->where('raspberry_id', $raspberry_id)
								->first();
		
		if ($duplicateRaspberry === null) 
		{
			Raspberry_Access::create([
				'user_id' => $user_id,
				'raspberry_id' => $raspberry_id
			]);
			$new_raspberry_message = "New";
		}
		else 
		{
			$new_raspberry_message = "Same";
		}
		return redirect()	->route('home')
							->with('ip_address', $ip_address)
							->with('new_raspberry_message', $new_raspberry_message);
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