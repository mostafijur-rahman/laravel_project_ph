<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class SettingDivision extends Model
{
    protected $table = 'setting_divisions';
    protected $primaryKey = 'id';
    protected $fillable = ['name',
        'status'
    ];
    protected $guarded = [];
}