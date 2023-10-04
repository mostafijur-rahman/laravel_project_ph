<?php

use Illuminate\Database\Seeder;

class SettingVehicleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('setting_vehicles')->insert([
            [
                'encrypt' =>  uniqid(),
                'vehicle_serial' => 1,
                'number_plate' => '11-9039',
                'ownership' => 'rental',
                'supplier_id' => 1,
                'driver_id' => 1,
                'helper_id' => 3,
                'created_by' => 1,
            ],
            [
                'encrypt' =>  uniqid(),
                'vehicle_serial' => 2,
                'number_plate' => '11-8082',
                'ownership' => 'company',
                'supplier_id' => 2,
                'driver_id' => 2,
                'helper_id' => 4,
                'created_by' => 1,
            ]
        ]);


    }

}
