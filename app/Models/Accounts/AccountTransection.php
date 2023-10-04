<?php

namespace App\Models\Accounts;

use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

use Illuminate\Database\Eloquent\Model;
use App\Models\Accounts\Account;
use App\Models\Settings\SettingBank;
use App\Models\Settings\SettingInvestor;
use App\User;

class AccountTransection extends Model
{
    use SoftDeletes;
    protected $table='account_trans';
    protected $fillable=['encrypt',
                        'investor_id',
                        'account_id',
                        'type',
                        'amount',
                        'status',
                        'date',
                        'transactionable_type',
                        'transactionable_id',
                        'for',
                        'note',
                        'created_by',
                        'updated_by'];


    public function account(){
    	return $this->belongsTo(Account::class, 'account_id')->withDefault();
    }
    
    public function investor(){
    	return $this->belongsTo(SettingInvestor::class, 'investor_id')->withDefault();
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-M-Y ');
    }

    public function transactionable()
    {
        return $this->morphTo();
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }
 
    public function user_update(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }
}