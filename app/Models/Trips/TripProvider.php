<?php

namespace App\Models\Trips;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingStaff;

class TripProvider extends Model
{
    use SoftDeletes;
    protected $table = 'trip_providers';
    protected $fillable = ['trip_id',
                            'ownership',
                            'vehicle_id',
                            'vehicle_number',
                            'driver_name',
                            'driver_phone',
                            'owner_name',
                            'owner_phone',
                            'reference_name',
                            'reference_phone',
                            'contract_fair',
                            'advance_fair',
                            'due_fair',
                            'deduction_fair',
                            'extend_fair',
                            'demarage',
                            'demarage_received',
                            'demarage_due',
                        ];

    public function vehicle(){
        return $this->belongsTo(SettingVehicle::class, 'vehicle_id')->withDefault();
    }
    
    public function driver(){
        return $this->belongsTo(SettingStaff::class, 'driver_id')->withDefault();
    }

    public function helper(){
        return $this->belongsTo(SettingStaff::class, 'helper_id')->withDefault();
    }

}