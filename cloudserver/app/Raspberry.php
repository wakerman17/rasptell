<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raspberry extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['ip_address'];
	
	protected $table = 'raspberry';
	
	public function store($ip_address)
    {
		$user = new User;
		$user->ip_address = $ip_address;
		$user->save();
	}
	
	/**
     * Get the accesses to the raspberries the user has. 
     */
    public function raspberry_access()
    {
        return $this->hasMany('App\Raspberry_Access');
    }
	
	/**
     * Get the device that the user owns.
     */
    public function device()
    {
        return $this->hasMany('App\Device');
    }
}
