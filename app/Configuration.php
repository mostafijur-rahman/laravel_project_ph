<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
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
    protected $table = 'configurations';

    /**
     * The primaryKey of this table with the model.
     *
     * @var string
     */
    protected $primaryKey = 'config_id';

    
    /**
     * for no need timestamps 
     *
     * @var boolean
     */
    public $timestamps = false;
}
