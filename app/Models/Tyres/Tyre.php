<?php

namespace App\Models\Tyres;
use Illuminate\Database\Eloquent\Model;
use App\Models\Purchases\Purchase;
use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingBrand;
use App\User;
use Carbon\Carbon;

class Tyre extends Model
{
    protected $table = 'tyres';
    protected $primaryKey = 'id';
    protected $fillable = ['encrypt',
                            'brand_id',
                            'tyre_number',
                            'warranty_km',
                            'vehicle_id',
                            'attach_date',
                            'position_id',
                            'notify_km',
                            'notify_date',
                            'note',
                            'created_by',
                            'updated_by',
                        ];

    public function purchase()
    {
        return $this->morphOne(Purchase::class, 'purchaseable');
    }

    public function brand(){
        return $this->belongsTo(SettingBrand::class,'brand_id')->withDefault();
    }

    // public function position(){
    //     return $this->belongsTo(SettingArea::class,'position_id')->withDefault();
    // }

    public function vehicle(){
        return $this->belongsTo(SettingVehicle::class, 'vehicle_id')->withDefault();
    }

    public function created_user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function updated_user(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function setAttachDateAttribute($value)
    {
        $this->attributes['attach_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

}