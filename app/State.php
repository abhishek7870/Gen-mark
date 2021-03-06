<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = ['state_name'];

    protected $dates =['created_at','updated_at'];

    public function dealers()
    {
    	return $this->hasMany('App\Dealer','state_id');
    }
}
