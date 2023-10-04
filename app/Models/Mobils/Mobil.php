<?php

namespace App\Models\Mobils;
use Illuminate\Database\Eloquent\Model;

use App\Models\Purchases\Purchase;
use App\Models\Settings\SettingBrand;
use App\Models\Settings\SettingVehicle;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;

class Mobil extends Model
{
    use SoftDeletes;
    protected $table = 'mobils';
    protected $primaryKey = 'id';
    protected $fillable = ['encrypt',
                            'brand_id',
                            'liter',
                            'warranty_km',
                            'vehicle_id',
                            'attach_date',
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

    public function vehicle(){
        return $this->belongsTo(SettingVehicle::class, 'vehicle_id')->withDefault();
    }

    public function created_user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function updated_user(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }
}