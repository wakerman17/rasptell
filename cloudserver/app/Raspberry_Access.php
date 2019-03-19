<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raspberry_Access extends Model
{
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
	protected $fillable = [
		'user_id', 
		'raspberry_id'
	];
	
	protected $table = 'raspberry_access';
	
	/**
     * Get the user that has the raspberry.
     */
    public function user()
    {
        return $this->belongsTo('App\User', 'id');
    }
	
	/**
     * Get the raspberry that the user owns.
     */
    public function raspberry()
    {
        return $this->belongsTo('App\Raspberry', 'id');
    }
}