<?php

namespace App\Models\Companies;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Settings\SettingCompany;
use App\User;
use Carbon\Carbon;

class CompanyTransection extends Model
{
    use SoftDeletes;
    protected $table = 'company_trans';
    protected $fillable = ['company_id',
                            'type',
                            'amount',
                            'date',
                            'transactionable_type',
                            'transactionable_id',
                            'note',
                            'created_by',
                            'updated_by',
                        ];

    protected $guarded = [];

    public function setDateAttribute($value){
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function company(){
        return $this->belongsTo(SettingCompany::class, 'company_id')->withDefault();
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }
 
    public function user_update(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

}
