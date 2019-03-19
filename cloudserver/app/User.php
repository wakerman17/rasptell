<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','raspberry_id','admin_level','remember_token'
    ];
	
	protected $table = 'user';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
	
	public function getRememberToken()
	{
		return null; 
	}

	public function setRememberToken($value){}

	public function getRememberTokenName()
	{
		return null; 
	}

	/**
	 * Overrides the method to ignore the remember token.
	 */
	public function setAttribute($key, $value)
	{
		$isRememberTokenAttribute = $key == $this->getRememberTokenName();
		if (!$isRememberTokenAttribute)
		{
			parent::setAttribute($key, $value);
		}
	}
	
	/**
     * Get the accesses to the raspberries the user has. 
     */
    public function raspberry_access()
    {
        return $this->hasMany('App\Raspberry_For_User');
    }
	
	/**
     * Get the accesses for the devices blog the user has.
     */
    public function device_access()
    {
        return $this->hasMany('App\Device_Access');
    }
}
