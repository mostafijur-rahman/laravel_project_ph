<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Capital extends Model
{
    public function user(){
    	return $this->belongsTo(\App\User::class, "created_by")->withDefault();
    }

    public function getDateAttribute($date){
        return Carbon::parse($date)->format('d M y');
    }

    public function getCreatedAtAttribute($date){
        return Carbon::parse($date)->format('d M y h:i a');
    }

    public function account(){
    	return $this->belongsTo(\App\Account::class, "code", "code")->withDefault();
    }
    
    public function car(){
        return $this->belongsTo(\App\Vehicle::class, "car_id")->withDefault();
    }

    public function history(){
        return $this->hasMany(CapitalHistory::class, "capital_id");
    }
}
