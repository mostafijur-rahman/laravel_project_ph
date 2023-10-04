<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Counter extends Model
{
    /**
     * for the mass assignable
     *
     * @var string
     */
    protected $guarded = [];

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'counters';

    /**
     * The primaryKey of this table with the model.
     *
     * @var string
     */
    protected $primaryKey = 'counter_id';
}
