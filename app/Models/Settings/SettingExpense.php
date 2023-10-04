<?php

namespace App\Models\Settings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SettingExpense extends Model
{
    use SoftDeletes;
    protected $table = 'setting_expenses';
    protected $fillable = ['encrypt',
                            'expense_type_id',
                            'head',
                            'description',
                            'sort',
                            'type',
                            'created_by',
                            'updated_by'];
    protected $guarded = [];

}
