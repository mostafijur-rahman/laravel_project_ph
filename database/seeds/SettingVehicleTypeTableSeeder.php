<?php

use Illuminate\Database\Seeder;

class SettingVehicleTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('setting_vehicle_types')->insert([
            ['name' => 'bus'],
            ['name' => 'coverd_van'],
            ['name' => 'pickup'],
            ['name' => 'micro_bus']
        ]);
    }
    // translation implement




}
