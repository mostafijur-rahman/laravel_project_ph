<?php

namespace App\Models\Trips;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Settings\SettingPump;
use App\Models\Accounts\AccountTransection;
use App\Models\Settings\SettingVehicle;
use App\Models\Trips\Trip;
use App\User;

use Carbon\Carbon;

class TripOilExpense extends Model
{
    use SoftDeletes;
    protected $table = 'trip_oil_expenses';
    protected $fillable = ['encrypt',
                            'vehicle_id',
                            'trip_id',
                            'pump_id',
                            'voucher_id',
                            'liter',
                            'rate',
                            'bill',
                            'date',
                            'note',
                            'created_by',
                            'updated_by',
                        ];
                        
    public function pump(){
        return $this->belongsTo(SettingPump::class, 'pump_id')->withDefault();
    }

    public function transaction()
    {
        return $this->morphOne(AccountTransection::class, 'transactionable');
    }

    public function trip(){
        return $this->belongsTo(Trip::class, 'trip_id')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function user_update(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function vehicle(){
    	return $this->belongsTo(SettingVehicle::class, 'vehicle_id')->withDefault();
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }


}
