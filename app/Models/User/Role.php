<?php

namespace App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;
    protected $table = 'user_roles';
    protected $fillable = ['name',
                            'read',
                            'create',
                            'edit',
                            'delete',
                            'created_by',
                            'updated_by'];
}