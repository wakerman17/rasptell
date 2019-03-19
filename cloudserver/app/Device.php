<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
	protected $table = 'device';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'device_name', 'raspberry_id'
    ];
	
	/**
     * Get the users that owns this device.
     */
    public function users()
    {
        return $this->hasMany('App\User_Access', 'id');
    }
	
	/**
     * Get the raspberry that owns this device.
     */
    public function raspberry()
    {
        return $this->belongsTo('App\Raspberry', 'id');
    }
}
