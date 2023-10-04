<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Trips\Trip;
use App\Models\Settings\SettingDivision;

class SettingArea extends Model
{
    use SoftDeletes;
    protected $table = 'setting_areas';
    protected $primaryKey = 'id';
    protected $fillable = ['division_id',
        'district_id',
        'name',
        'distance',
        'name',
        'created_by',
        'updated_by',
    ];
    protected $guarded = [];

    public function trips()
    {
        return $this->belongsToMany(Trip::class, 'setting_area_trip','setting_area_id','trip_id');
    }

    public function division(){
        return $this->belongsTo(SettingDivision::class, 'division_id')->withDefault();
    }

}