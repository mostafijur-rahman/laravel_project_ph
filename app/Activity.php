<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $guarded = [];
    protected $table = 'activites';
    protected $fillable = [
                    'table_name',
                    'table_id',
                    'for'

    ];
}
