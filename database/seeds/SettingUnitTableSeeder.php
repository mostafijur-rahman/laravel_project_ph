<?php

use Illuminate\Database\Seeder;

class SettingUnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('setting_units')->insert([
            [
                'name' =>'ton',
                'created_by' => 1,
            ],
            [
                'name' =>'maund',
                'created_by' => 1,
            ],
            [
                'name' =>'kg',
                'created_by' => 1,
            ],
        ]);
    }
}
