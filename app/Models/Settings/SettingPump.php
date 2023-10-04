<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Trips\TripOilExpense;

class SettingPump extends Model
{
    use SoftDeletes;
    protected $table = 'setting_pumps';
    protected $fillable = ['encrypt',
                            'sort',
                            'name',
                            'phone',
                            'address',
                            'note',
                            'created_by',
                            'updated_by'
                        ];

    public function oil_expenses()
    {
        return $this->hasMany(TripOilExpense::class, 'pump_id');
    }


}
