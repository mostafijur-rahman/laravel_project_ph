<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class InstallmentHistory extends Model
{
    // mutate
    public function getPayDateAttribute($date){
        return Carbon::parse($date)->format('d M y');
    }

    public function installment(){
    	return $this->belongsTo(Installment::class, 'install_id');
    }
}