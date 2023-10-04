<?php

namespace App\Models\Purchases;
use Illuminate\Database\Eloquent\Model;
use App\Models\Settings\SettingSupplier;
use App\Models\Transections\Transection;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\User;
use Carbon\Carbon;

class Purchase extends Model
{
    use SoftDeletes;
    protected $table = 'purchases';
    protected $primaryKey = 'id';
    protected $fillable = ['encrypt',
                            'purchaseable_type',
                            'purchaseable_id',
                            'supplier_id',
                            'date',
                            'price',
                            'paid',
                            'due',
                            'discount',
                            'note',
                            'created_by',
                            'updated_by',
                        ];


    public function purchaseable()
    {
        return $this->morphTo();
    }

    public function supplier(){
        return $this->belongsTo(SettingSupplier::class,'supplier_id')->withDefault();
    }

    public function created_user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function updated_user(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

    public function setDateAttribute($value)
    {
        $this->attributes['date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    public function transaction()
    {
        return $this->morphOne(Transection::class, 'transactionable');
    }

}