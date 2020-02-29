<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable =['key','company_code','name','api_url','sms_registration_url','sms_verification_url','dealer_verification_url','dealer_registration_url'];

    protected $dates ['created_at','updated_at'];
}
