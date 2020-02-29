<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Code extends Model
{
    protected $fillable =['codeable_id','codeable_type','code'];

    protected $dates =['created_at','updated_at'];

    public function codeable()
    {
    	return $this->morphTo();
    }
}
