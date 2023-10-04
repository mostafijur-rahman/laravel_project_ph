<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Car_info extends Model
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
    protected $table = 'car_infos';

    /**
     * The primaryKey of this table with the model.
     *
     * @var string
     */
    protected $primaryKey = 'car_id';

}
