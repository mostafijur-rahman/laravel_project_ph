<?php

namespace App\Models\Shares;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Share extends Model
{
    use SoftDeletes;
    protected $table = 'shares';
    protected $fillable = ['encrypt',
                            'filter',
                            'validity',
                            'created_by',
                            'updated_by'];

}