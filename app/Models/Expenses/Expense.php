<?php

namespace App\Models\Expenses;
use Illuminate\Database\Eloquent\Model;

use App\Models\Trips\Trip;
use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingExpense;
use App\Models\Accounts\AccountTransection;
use App\User;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use SoftDeletes;
    protected $table = 'expenses';
    protected $fillable = ['encrypt',
                            'vehicle_id',
                            'trip_id',
                            'expense_id',
                            'voucher_id',
                            'amount',
                            'date',
                            'note',
                            'created_by',
                            'updated_by'];
    protected $guarded = [];

    // protected $dates = [ 'date'];

    public function vehicle(){
    	return $this->belongsTo(SettingVehicle::class, 'vehicle_id')->withDefault();
    }

    public function trip(){
    	return $this->belongsTo(Trip::class, 'trip_id')->withDefault();
    }

    public function expense(){
    	return $this->belongsTo(SettingExpense::class, 'expense_id')->withDefault();
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }

    public function getDateAttribute($input)
    {
        return Carbon::createFromFormat('Y-m-d', $input)->format('d-M-Y');
    }

    public function transaction()
    {
        return $this->morphOne(AccountTransection::class, 'transactionable');
    }

    public function user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function user_update(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

}