<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    protected $guarded = [];

    public function car(){
        return $this->belongsTo(Vehicle::class, 'car_id')->withDefault();
    }

    public function Installment_history(){
        return $this->hasMany(InstallmentHistory::class, 'install_id');
    }
    public function Installment_down_payment(){
        return $this->hasOne(InstallmentHistory::class, 'install_id')->where('pay_type', 2);
    }
    public function installment(){
        return $this->hasMany(InstallmentHistory::class, 'install_id')->where('pay_type', 1);
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }
    public function provider(){
        return $this->belongsTo(SettingProvider::class, 'providers_id')->withDefault();
    }
}
