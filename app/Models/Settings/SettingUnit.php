<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingUnit extends Model
{
    use SoftDeletes;
    protected $table = 'setting_units';
    protected $primaryKey = 'id';
    protected $fillable = [
                        'sort',
                        'name',
                        'created_by',
                        'updated_by',
                    ];
}
