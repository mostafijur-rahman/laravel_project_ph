<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\User\Role;

class User extends Authenticatable
{
    use Notifiable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
                        'first_name',
                        'last_name',
                        'email',
                        'password',
                        'role_id',
                        'status',
                        'ip',
                        'updated_by',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'full_name'
    ];

    public function getFullNameAttribute(): string
    {
        return $this->first_name . ($this->last_name ? ' ' . $this->last_name : '');
    }

    public function role(){
    	return $this->belongsTo(Role::class, 'role_id')->withDefault();
    }

}
