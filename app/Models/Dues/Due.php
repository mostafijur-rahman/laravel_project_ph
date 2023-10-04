<?php

namespace App\Models\Dues;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class Due extends Model
{
    public function getDateAttribute($date){
        return Carbon::parse($date)->format('d M y');
    }

    public function trip(){
    	return $this->belongsTo(Trip::class, 'table_id')->withDefault();
    }

    public function due_collection(){
    	return $this->belongsTo(DueCollection::class, 'table_id')->withDefault();
    }

}
