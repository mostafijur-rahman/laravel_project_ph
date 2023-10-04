<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investor extends Model
{
    public function trasport_invest(){
    	return $this->hasOne(Capital::class, 'invenstor_id')->where('business_type', 1);
    }

    public function trip_invest(){
    	return $this->hasOne(Capital::class, 'invenstor_id')->where('business_type', 2);
    }
}
