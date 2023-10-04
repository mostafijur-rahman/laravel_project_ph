<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SettingStaffReference extends Model
{
    use SoftDeletes;

    protected $table = 'setting_staff_references';
    protected $fillable = ['staff_id', 'referrer', 'relation', 'phone', 'nid_number', 'address', 'main_referrer', 'created_by', 'updated_by'];

    protected $guarded = [];


}
