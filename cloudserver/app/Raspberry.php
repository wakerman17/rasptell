<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Raspberry extends Model
{
    protected $fillable = ['ip_address'];
	
	protected $table = 'raspberry';
}
