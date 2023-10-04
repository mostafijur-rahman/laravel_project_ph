<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class SettingDesignation extends Model
{
    protected $table = 'setting_designations';
    protected $primaryKey = 'id';
    protected $fillable = ['encrypt',
        'name',
        'created_by',
        'updated_by',
    ];
    protected $guarded = [];
}