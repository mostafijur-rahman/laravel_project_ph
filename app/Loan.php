<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    protected $guarded = [];
    protected $table = 'loans';
    protected $primaryKey = 'id';

    public function client_info(){
        return $this->belonsTo(Client::class, "client_id");
    }

}