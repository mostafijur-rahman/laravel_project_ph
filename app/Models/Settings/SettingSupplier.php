<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingSupplier extends Model
{
    use SoftDeletes;
    protected $table = 'setting_suppliers';
    protected $primaryKey = 'id';
    protected $fillable = ['encrypt',
        'type',
        'sort',
        'no',
        'name',
        'receivable_amount',
        'payable_amount',
        'phone',
        'address',
        'note',
        'created_by',
        'updated_by',
    ];
    protected $guarded = [];

    /**
     * for the trip supplier details
     */
    public function client()
    {
        return $this->morphOne(Trip::class, 'clientable');
    }
}
