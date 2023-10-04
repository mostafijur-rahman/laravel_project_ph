<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingInvestor extends Model
{
    use SoftDeletes;
    protected $table = 'setting_investors';
    protected $primaryKey = 'id';
    protected $fillable = [
        'name',
        'sort',
        'created_by',
        'updated_by',
    ];
    protected $guarded = [];

}