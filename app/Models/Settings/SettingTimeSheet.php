<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class SettingTimeSheet extends Model
{

    protected $table = 'setting_time_sheets';
    protected $primaryKey = 'id';
    protected $fillable = ['encrypt',
        'sort',
        'no',
        'name',
        'phone',
        'address',
        'note',
        'created_by',
        'updated_by',
    ];
    protected $guarded = [];

}
