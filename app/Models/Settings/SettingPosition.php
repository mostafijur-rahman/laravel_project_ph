<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;

class SettingPosition extends Model
{
    protected $table = 'setting_positions';
    protected $primaryKey = 'id';
    protected $fillable = ['name','sort'];
    protected $guarded = [];

}