<?php

namespace App\Models\Settings;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;
use App\Models\Trips\Trip;
use App\Models\Trips\TripCompany;
// use App\Models\Companies\CompanyTransection;

class SettingCompany extends Model
{
    use SoftDeletes;
    protected $table = 'setting_companies';
    protected $primaryKey = 'id';
    protected $fillable = ['encrypt',
                            'sort',
                            'name',
                            'phone',
                            'address',
                            'note',
                            'created_by',
                            'updated_by',
                        ];

    // 'trip_receivable_date',
    // 'trip_receivable_amount',
    // 'transport_receivable_date',
    // 'transport_receivable_amount',

    protected $guarded = [];
    // protected $casts = [
    //     'trip_receivable_date' => 'date'
    // ];

    // public function client(){
    //     return $this->morphOne(Trip::class, 'clientable');
    // }

    public function tripDueFairHistories(){
        return $this->hasMany(Trip::class, 'company_id')->where('due_fair', '>', 0);
    }
    public function setTripReceivableDateAttribute($value){
        $this->attributes['trip_receivable_date'] = Carbon::createFromFormat('d/m/Y', $value)->format('Y-m-d');
    }
    // public function getTripReceivableDateAttribute($value){
    //     // return Carbon::parse($value)->format('d/m/Y');        
    //     return date('d/m/Y', strtotime($this->attributes['trip_receivable_date']));        
    // }

    // public function transport_due_fair_histories(){
    //     return $this->hasMany(Transport::class, 'company_id')->where('company_due_fair', '>', 0);
    // }

    // public function transport_due_fair_collection_histories(){
    //     return $this->hasMany(TransportDueCollection::class, 'companyable_id');
    // }

    // public function dueCollectionHistories(){
    //     return $this->hasMany(TransportDueCollection::class, 'companyable_id');
    // }

    // public function due_trips(){
    //     return $this->hasMany(Trip::class, 'trip_client_id')->where('trip_due_fair', '>', 0)->where('trip_stage', 3);
    // }

    // public function trips(){
    //     return $this->hasMany(Trip::class, 'trip_client_id');
    // }

    // public function dues(){
    //     return $this->hasMany(Due::class, 'client_id');
    // }

    // public function discount(){
    //     return $this->hasMany(Trip::class, 'trip_client_id')->where('trip_deduction_fair', '>', 0);
    // }

    // public function collection_history(){
    //     return $this->hasMany(DueCollection::class, 'client_id');
    // }

    // public function company_transections(){
    //     return $this->hasMany(CompanyTransection::class, 'company_id');
    // }

    // public function present_total_advance(){
    //     return $this->hasMany(CompanyTransection::class, 'company_id')->where('type', 'in_from_company');
    // }

    // public function present_total_dues(){
    //     return $this->hasMany(CompanyTransection::class, 'company_id')->where('type', 'out_for_trip');
    // }

    public function trips(){
        return $this->hasMany(TripCompany::class, 'company_id');
    }

}
