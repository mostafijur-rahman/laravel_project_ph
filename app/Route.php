<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
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
    protected $table = 'routes';

    /**
     * The primaryKey of this table with the model.
     *
     * @var string
     */
    protected $primaryKey = 'route_id';
}
