<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Raspberry_For_User extends Authenticatable
{
	protected $fillable = [
		'user_id', 
		'raspberry_id'
	];
	
	protected $table = 'raspberry_for_user';
}