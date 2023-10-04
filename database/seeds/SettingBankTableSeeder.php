<?php

use Illuminate\Database\Seeder;
use App\Models\Settings\SettingBank;

class SettingBankTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

       $model = new SettingBank();
       $model->sort = 2;
       $model->name = 'IBBL';
       $model->created_by = 1;
       $model->save();

       $model = new SettingBank();
       $model->sort = 1;
       $model->name = 'DBBL';
       $model->created_by = 1;
       $model->save();

       $model = new SettingBank();
       $model->sort = 3;
       $model->name = 'BRAC';
       $model->created_by = 1;
       $model->save();

       $model = new SettingBank();
       $model->sort = 4;
       $model->name = 'City Bank';
       $model->created_by = 1;
       $model->save();

       $model = new SettingBank();
       $model->sort = 5;
       $model->name = 'IFIC';
       $model->created_by = 1;
       $model->save();

    }
}
