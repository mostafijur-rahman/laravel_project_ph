<?php

namespace App\Models\Trips;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Accounts\AccountTransection;
use App\Models\Trips\Trip;
use Carbon\Carbon;


class TripChallan extends Model
{
    use SoftDeletes;
    protected $table = 'trip_challans';
    protected $fillable = ['trip_id',
                            'voucher_id',
                            'account_transection_id',
                            'for',
                            'date',
                            'recipients_name',
                            'recipients_phone',
                            'amount',
                        ];

    public function setDateAttribute($value){
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    
    public function trip(){
        return $this->belongsTo(Trip::class, 'trip_id')->withDefault();
    }
    
    public function transection(){
        return $this->belongsTo(AccountTransection::class, 'account_transection_id')->withDefault();
    }
}