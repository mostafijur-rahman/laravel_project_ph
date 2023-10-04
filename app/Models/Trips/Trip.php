<?php

namespace App\Models\Trips;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingStaff;
use App\Models\Settings\SettingArea;
use App\Models\Settings\SettingTimeSheet;
use App\Models\Settings\SettingUnit;
use App\Models\Trips\TripCompany;
use App\Models\Trips\TripProvider;
use App\Models\Trips\TripMeter;
use App\Models\Trips\TripOilExpense;
use App\Models\Trips\TripDemarage;
use App\Models\Trips\TripChallan;
use App\Models\Trips\TripChallanReceivedHistory;
use App\Models\Accounts\AccountTransection;
use App\Models\Expenses\Expense;
use App\User;

class Trip extends Model
{
    use SoftDeletes;
    protected $table = 'trips';
    protected $fillable = ['type',
                            'group_id',
                            'encrypt',
                            'number',
                            'date',
                            'account_take_date',
                            'serial',
                            'time_id',
                            'box',
                            'weight',
                            'unit_id',
                            'goods',
                            'buyer_name',
                            'buyer_code',
                            'order_no',
                            'depu_change_bill',
                            'gate_pass_no',
                            'lock_no',
                            'load_point_reach_time',
                            'note',
                            'created_by',
                            'updated_by',
                        ];

    // mutet
    // public function getTripDateAttribute($value){
    //     return Carbon::parse($value)->format('d M y');
    // }

    // relation
    public function vehicle(){
    	return $this->belongsTo(SettingVehicle::class, 'vehicle_id')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function user_update(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    // public function load_data(){
    //     return $this->belongsTo(SettingArea::class,'load_id')->withDefault();
    // }

    // public function unload(){
    //     return $this->belongsTo(SettingArea::class, 'unload_id')->withDefault();
    // }

    public function driver(){
        return $this->belongsTo(SettingStaff::class, 'driver_id')->withDefault();
    }

    public function load_time(){
        return $this->belongsTo(SettingTimeSheet::class, 'time_id')->withDefault();
    }

    public function company(){
        return $this->hasOne(TripCompany::class, 'trip_id')->withDefault();
    }

    public function provider(){
        return $this->hasOne(TripProvider::class, 'trip_id')->withDefault();
    }

    public function oilExpenses(){
        return $this->hasMany(TripOilExpense::class, 'trip_id', 'id');
    }

    // public function generalExpenses(){
    //     return $this->hasMany(TripGeneralExpense::class, 'trip_id', 'id');
    // }

    public function getTripsByNumber(){
        return $this->hasMany(Trip::class, 'number', 'number')->orderBy('date', 'asc');
    }

    public function getTripsByGroupId(){
        return $this->hasMany(Trip::class, 'group_id', 'group_id')->orderBy('id', 'desc');
    }

    public function meter(){
        return $this->hasOne(TripMeter::class, 'trip_id')->withDefault();
    }

    public function setAccountTakeDateAttribute($value){
        $this->attributes['account_take_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function setDateAttribute($value){
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function points(){
        return $this->belongsToMany(SettingArea::class, 'setting_area_trip','trip_id','setting_area_id')->withPivot('point');
    }

    // public function challans(){
    //     return $this->belongsToMany(AccountTransection::class, 'account_transection_trip','trip_id','account_transection_id')->withPivot('for','date','recipients_name','recipients_phone','amount');
    // }

    public function challans(){
        return $this->hasMany(TripChallan::class, 'trip_id', 'id');
    }

    public function unit(){
        return $this->belongsTo(SettingUnit::class, 'unit_id')->withDefault();
    }

    public function demarage(){
        return $this->hasMany(TripDemarage::class, 'trip_id', 'id');
    }
    
    public function expenses(){
        return $this->hasMany(Expense::class, 'trip_id', 'id');
    }

    public function transactions()
    {
        return $this->morphMany(AccountTransection::class, 'transactionable');
    }

    public function challanHistoryReceived(){
        return $this->hasOne(TripChallanReceivedHistory::class, 'trip_id');
    }

}
