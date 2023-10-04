<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProjectExpense extends Model
{
    protected $guarded = [];
    protected $table = 'project_expenses';
    protected $primaryKey = 'project_exp_id';


}