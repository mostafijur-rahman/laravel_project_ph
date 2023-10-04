<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $guarded = [];
    protected $table = 'clients';
    protected $primaryKey = 'client_id';

    public function due_trips(){
        return $this->hasMany(Trip::class, 'trip_client_id')->where('trip_due_fair', '>', 0)->where('trip_stage', 3);
    }

    public function due_transports(){
        return $this->hasMany(Transport::class, 'trans_client_id')->where('trans_client_due_fair', '>', 0);
    }

    public function trips(){
        return $this->hasMany(Trip::class, 'trip_client_id');
    }

    public function dues(){
        return $this->hasMany(Due::class, 'client_id');
    }

    public function discount(){
        return $this->hasMany(Trip::class, 'trip_client_id')->where('trip_deduction_fair', '>', 0);
    }

    public function collection_history(){
        return $this->hasMany(DueCollection::class, 'client_id');
    }

    public function trans_due_collection(){
        return $this->hasMany(TransportDueCollection::class, 'client_id');
    }
}
