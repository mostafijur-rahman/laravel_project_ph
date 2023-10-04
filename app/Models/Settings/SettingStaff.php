<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class SettingStaff extends Model
{
    use SoftDeletes;

    protected $table = 'setting_staffs';
    protected $fillable = ['encrypt',
        'sort',
        'gender',
        'name',
        'phone',
        'email',
        'father_name',
        'mother_name',
        'spouse_name',
        'present_address',
        'permanent_address',
        'dob',
        'joining_date',
        'blood_group',

        'company_id',
        'designation_id',
        'nid_number',
        'driving_license_number',
        'passport_number',
        'birth_certificate_number',
        'port_id',
        'bank_id',
        'bank_account_number',
        'salary_amount',
        'termination_date',

        'reference_name',
        'reference_phone',
        'reference_nid_number',
        'reference_present_address',
        'note',
        'status',
        'created_by',
        'updated_by',

    ];

    protected $guarded = [];

    public function designation(){
    	return $this->belongsTo(SettingDesignation::class, 'designation_id')->withDefault();
    }

    public function setDobAttribute($value){
        $this->attributes['dob'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function setJoiningDateAttribute($value){
        $this->attributes['joining_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    // public function setTerminationDateAttribute($value){
    //     $this->attributes['termination_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    // }

    public function bank(){
    	return $this->belongsTo(SettingBank::class, 'bank_id')->withDefault();
    }

    

}
