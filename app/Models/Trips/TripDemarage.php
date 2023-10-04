<?php

namespace App\Models\Trips;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class TripDemarage extends Model
{
    use SoftDeletes;
    protected $table = 'trip_demarages';
    protected $fillable = ['trip_id',
                            'date',
                            'company_amount',
                            'provider_amount',
                            'note',
                            'created_by',
                            'updated_by'];
    protected $guarded = [];

    // public function setDateAttribute($value){
    //     $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    // }

    // public function trip(){
    //     return $this->belongsTo(Trip::class, 'trip_id')->withDefault();
    // }

}
