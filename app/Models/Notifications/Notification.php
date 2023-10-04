<?php

namespace App\Models\Notifications;
use Illuminate\Database\Eloquent\Model;

use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use SoftDeletes;

    protected $table = 'notifications';

    protected $fillable = ['user_id',
                            'type',
                            'content',
                            'seen',
                            'seen_at',
                            'sms_id',
                        ];

    
    public function user_for(){
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

}