<?php

namespace App\Models\Trips;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TripMeter extends Model
{
    use SoftDeletes;
    protected $table = 'trip_meters';
    protected $fillable = ['encrypt',
                            'vehicle_id',
                            'trip_id',
                            'previous_reading',
                            'current_reading',
                            'created_by',
                            'updated_by',
                        ];
    protected $guarded = [];

    // public function trip(){
    //     return $this->belongsTo(Trip::class, 'trip_id')->withDefault();
    // }

}
