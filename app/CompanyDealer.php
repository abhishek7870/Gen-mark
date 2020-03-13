<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CompanyDealer extends Model
{
     protected $fillable = ['dealer_id','company_id'];

     protected $dates = ['created_at','updated_at'];
}
