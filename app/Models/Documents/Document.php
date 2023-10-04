<?php

namespace App\Models\Documents;
use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $table = 'documents';
    protected $primaryKey = 'id';
    protected $fillable = ['setting_vehicle_id',
                            'tax_token_registration',
                            'tax_token_expire',
                            'fitness_registration',
                            'fitness_expire',
                            'road_permit_registration',
                            'road_permit_expire',
                            'insurance_registration',
                            'insurance_expire',
                            'blue_book_registration',
                            'blue_book_expire',
                            'created_by',
                            'updated_by',
                        ];

                        

}