<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CarType extends Model
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
    protected $table = 'car_types';

    /**
     * The primaryKey of this table with the model.
     *
     * @var string
     */
    protected $primaryKey = 'car_type_id';
}
