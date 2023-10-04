<?php

namespace App\Models\Dues;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;

class DueCollection extends Model
{

    protected $table = 'due_collections';
    protected $primaryKey = 'id';
    protected $fillable = ['encrypt',
                            'business',
                            'date',
                            'company_id',
                            'amount',
                            'amount_history',
                            'created_by',
                            'updated_by'
                        ];

    // public function getDateAttribute($date){
    //     return Carbon::parse($date)->format('d M y');
    // }

    // public function client(){
    // 	return $this->belongsTo(Client::class, 'client_id')->withDefault();
    // }

    // public function account(){
    //     return $this->belongsTo(Account::class, 'encrypt', 'code')->withDefault();
    // }

    // public function car(){
    //     return $this->belongsTo(Vehicle::class, 'car_id')->withDefault();
    // }
}
