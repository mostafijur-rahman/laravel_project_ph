<?php

use Illuminate\Database\Seeder;

class SettingDesignationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('setting_designations')->insert([
            ['name' => 'driver'],
            ['name' => 'helper'],
            ['name' => 'executive'],
            ['name' => 'supervisor'],
        ]);
    }
}




