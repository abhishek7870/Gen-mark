<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Dealer extends Authenticatable implements JWTSubject
{
    protected $fillable =['first_name','last_name','email','phone_no','gst_no','state_id','city'];
    
    protected $dates =['created_at','updated_at'];
    public function getJWTIdentifier()
  {
    return $this->getKey();
  }

  public function getJWTCustomClaims()
  {
    return [];
  }
  
  public static function authenticateDealer($mobile)
    {
		$dealer = Dealer::where('phone_no','=',$mobile)->first();
		if($dealer) {
			return $dealer;
		}
		return false;
    }
   public function codes()
    {
       return $this->morphMany(Code::class, 'codeable');
    }
    public function companies()
     {
       return $this->belongsToMany('App\Company','company_dealers','company_id','dealer_id');
     } 
}
