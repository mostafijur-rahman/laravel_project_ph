<?php

use Illuminate\Database\Seeder;
use App\Models\Accounts\AccountTransection;
use Carbon\Carbon;

class AccountTransTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = AccountTransection::query()->truncate();
        $todayDate = Carbon::now()->format('d/m/Y');

        $data = new AccountTransection;
        $data->encrypt = uniqid();
        $data->account_id = 1;
        $data->type = 'in';
        $data->amount = 100000;
        $data->status = 'active';
        $data->date = $todayDate;
        $data->for = 'cash_in';
        $data->created_by = 1;
        $data->save();

        $data = new AccountTransection;
        $data->encrypt = uniqid();
        $data->account_id = 2;
        $data->type = 'in';
        $data->amount = 95000;
        $data->status = 'active';
        $data->date = $todayDate;
        $data->for = 'cash_in';
        $data->created_by = 1;
        $data->save();

        $data = new AccountTransection;
        $data->encrypt = uniqid();
        $data->account_id = 3;
        $data->type = 'in';
        $data->amount = 90000;
        $data->status = 'active';
        $data->date = $todayDate;
        $data->for = 'cash_in';
        $data->created_by = 1;
        $data->save();
    }
}
