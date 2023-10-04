<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingBrand extends Model
{
    use SoftDeletes;
    protected $table = 'setting_brands';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'sort',
        'created_by',
        'updated_by',
    ];
    protected $guarded = [];

}