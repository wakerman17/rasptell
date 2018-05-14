<?php

namespace App\Http\Controllers;

use App\User;
use Auth;
use App\Http\Controllers\Controller;
use \DateTime;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AccessController extends Controller
{
	$user = DB::table('users')
			->where('name', Auth::user()->name)
			->Where('email', Auth::user()->email)
			->first();
	$user_accesses = 	DB::table('raspberry_for_user')
						->where('user_id', $user->id)
						->get();
	$devices = array();
	foreach ($user_accesses as $user_access) {
		$devices[] = 	DB::table('device')
						->where('raspberry_id', $user_access->raspberry_id)
						->first();
	}
}
