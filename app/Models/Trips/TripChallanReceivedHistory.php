<?php

namespace App\Models\Trips;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Trips\Trip;
use Carbon\Carbon;


class TripChallanReceivedHistory extends Model
{
    use SoftDeletes;
    protected $table = 'trip_challan_received_histories';

    protected $fillable = ['trip_id',
                            'received_date',
                            'receiver_name',
                            'note',
                            'created_by',
                            'updated_by'];

    // public function setReceivedDateAttribute($value){
    //     $this->attributes['received_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    // }

    public function trip(){
        return $this->belongsTo(Trip::class, 'trip_id')->withDefault();
    }

}