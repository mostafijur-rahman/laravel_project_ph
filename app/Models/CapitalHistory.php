<?php

namespace App\Models;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class CapitalHistory extends Model
{
    public function car(){
        return $this->belongsTo(\App\Vehicle::class, "vehicle_id")->withDefault();
    }

    public function getDateAttribute($date){
        return Carbon::parse($date)->format('d M y');
    }

}
