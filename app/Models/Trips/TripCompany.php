<?php

namespace App\Models\Trips;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Settings\SettingCompany;


class TripCompany extends Model
{
    use SoftDeletes;
    protected $table = 'trip_companies';
    protected $fillable = ['trip_id',
                            'company_id',
                            'contract_fair',
                            'advance_fair',
                            'due_fair',
                            'deduction_fair',
                            'extend_fair',
                            'demarage',
                            'demarage_received',
                            'demarage_due',
                        ];

    public function company(){
        return $this->belongsTo(SettingCompany::class, 'company_id')->withDefault();
    }
}