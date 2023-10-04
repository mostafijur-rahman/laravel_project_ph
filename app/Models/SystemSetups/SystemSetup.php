<?php

namespace App\Models\SystemSetups;

use Illuminate\Database\Eloquent\Model;

class SystemSetup extends Model
{
    protected $table = 'system_setups';
    protected $fillable = ['key', 'value'];
    public $timestamps = false;
}