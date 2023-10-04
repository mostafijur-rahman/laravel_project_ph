<?php

use Illuminate\Database\Seeder;
use App\Models\Accounts\Account;

class AccountTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = Account::query()->truncate();

        $data = new Account;
        $data->sort = 1;
        $data->type = 'cash';
        $data->bank_id = null;
        $data->holder_name = null;
        $data->account_number = null;
        $data->user_name = 'অফিস';
        $data->balance = 100000;
        $data->created_by = 1;
        $data->save();

        $data = new Account;
        $data->sort = 2;
        $data->type = 'bank';
        $data->bank_id = 1;
        $data->holder_name = 'মোস্তাফিজুর রহমান';
        $data->account_number = 2951;        
        $data->user_name = 'রহিম';        
        $data->balance = 95000;        
        $data->created_by = 1;
        $data->save();

        $data = new Account;
        $data->sort = 3;
        $data->type = 'bank';
        $data->bank_id = 2;
        $data->holder_name = 'মোস্তাফিজুর রহমান';
        $data->account_number = 3576;        
        $data->user_name = 'শরীফ';        
        $data->balance = 90000;   
        $data->created_by = 1;
        $data->save();
    
    }
}
