<?php

namespace App\Models\Accounts;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

use App\Models\Settings\SettingBank;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Account extends Model
{
    use SoftDeletes;
    protected $table = 'accounts';
    protected $fillable = ['sort',
                            'type',
                            'bank_id',
                            'holder_name',
                            'user_name',
                            'account_number',
                            'balance',
                            'note',
                            'user_id',
                            'created_by',
                            'updated_by'];


    public function bank(){
    	return $this->belongsTo(SettingBank::class, 'bank_id')->withDefault();
    }
    public function setPreviousDateAttribute($value)
    {
        if($value){
            $this->attributes['previous_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
        }
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }
 
    public function user_update(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function connected_user(){
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

}