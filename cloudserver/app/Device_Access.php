<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device_Access extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
        'user_id', 
		'device_id'
    ];
	
	protected $table = 'device_access';
	
	/**
     * Get the user that has the device.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
	
	/**
     * Get the device that the user owns.
     */
    public function device()
    {
        return $this->belongsTo('App\Device', 'id');
    }
}