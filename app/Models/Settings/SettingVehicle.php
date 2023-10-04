<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\SettingSupplier;
use App\Models\Documents\Document;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingVehicle extends Model
{
    use SoftDeletes;
    protected $table = 'setting_vehicles';
    protected $primaryKey = 'id';
    protected $fillable = [
        'sort',
        'encrypt',
        'ownership',
        'vehicle_serial',
        'number_plate',
        'registration_number',
        'engine_number',
        'chassis_number',
        'model',
        'manufacturer_id',
        'body_type',
        'engine_down',
        'fuel_tank_capacity',
        'gps_id',
        'registration_year',
        'tax_token_expire_date',
        'fitness_expire_date',
        'insurance_expire_date',
        'last_tyre_change_date',
        'last_mobil_change_date',
        'last_servicing_date',

        'note',
        'supplier_id', // need to remove
        'driver_id',
        'helper_id',
        'vehicle_type_id', // need to remove

        'created_by',
        'updated_by',

    ];

    protected $guarded = [];


    public function driver(){
        return $this->belongsTo(SettingStaff::class, 'driver_id')->withDefault();
    }

    public function helper(){
        return $this->belongsTo(SettingStaff::class, 'helper_id')->withDefault();
    }

    public function supplier(){
        return $this->belongsTo(SettingSupplier::class, 'supplier_id')->withDefault();
    }

    public function installment(){
        return $this->hasOne(Installment::class, 'car_id');
    }

    public function total_project_expense(){
        return $this->hasMany(CarTotalProjectExpense::class, 'car_id');
    }

    public function document(){
        return $this->hasOne(Document::class, 'setting_vehicle_id')->withDefault();
    }
}
