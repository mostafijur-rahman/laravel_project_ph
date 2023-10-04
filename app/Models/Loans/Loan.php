<?php

namespace App\Models\Loans;
use Illuminate\Database\Eloquent\Model;

// use Carbon\Carbon;
use Illuminate\Database\Eloquent\SoftDeletes;

class Loan extends Model
{
    use SoftDeletes;
    protected $table = 'loans';
    protected $fillable = ['encrypt',
                        'vendor_id',
                        'vendor_table',
                        'reason_id',
                        'reason_table',
                        'date',
                        'amount',
                        'created_by',
                        'updated_by'];


    protected $guarded = [];


    // public function getDateAttribute($input)
    // {
    //     return Carbon::createFromFormat('Y-m-d', $input)->format('d-M-Y');
    // }


    public function user(){
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    public function user_update(){
        return $this->belongsTo(User::class, 'updated_by')->withDefault();
    }

}