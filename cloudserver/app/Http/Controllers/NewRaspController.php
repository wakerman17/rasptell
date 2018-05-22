<?php

namespace App\Http\Controllers;

use App\User;
use App\Raspberry;
use App\Raspberry_For_User;
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
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = '/home';
	
	/**
     * Create a new controller instance.
     *
     * @return void
     */
    /*public function __construct()
    {
        $this->middleware('guest');
    }*/
	
	 /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
		$this->validator($request->all())->validate();
		if (DB::table('raspberry')->where('ip_address', $request->input('ip_address'))->count() == 0) 
		{
			Raspberry::create([
				'ip_address' => $request->input('ip_address')
			]);
		}
		//get the raspberry
		$raspberry = 	DB::table('raspberry')
						->where('ip_address', $request->input('ip_address'))
						->value('id');
		//get the user
		$user = DB::table('user')
				->where('name', Auth::user()->name)
				->where('email', Auth::user()->email)
				->value('id');
		//check if this user already had this raspberry
		$duplicate = 	DB::table('raspberry_for_user')
						->where('user_id', $user)
						->where('raspberry_id', $raspberry)
						->get();
		if ($duplicate->isEmpty()) 
		{
			//if not insert to table
			Raspberry_For_User::create([
				'user_id' => $user,
				'raspberry_id' => $raspberry
			]);
		}
		
		return redirect()->route('home');
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

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
			'ip_address' => $data['ip_address'],
        ]);
    }
}