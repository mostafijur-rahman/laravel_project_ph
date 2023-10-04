<?php

use Illuminate\Database\Seeder;

class TripsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trips')->truncate();
        DB::Table('trips')->insert([
                'trip_encrypt' => 1571929892,
                'trip_number' => 1001,
                'route_id' => 1,
                'car_id' => 1,
                'note' => 'this is trip note',
                'created_by' => 1,
                'updated_by' => 1
            ]);
        DB::Table('trips')->insert([
                'trip_encrypt' => 1571929929,
                'trip_number' => 1002,
                'route_id' => 2,
                'car_id' => 2,
                'note' => 'this is trip note',
                'created_by' => 1,
                'updated_by' => 1
            ]);
        DB::Table('trips')->insert([
                'trip_encrypt' => 1571929936,
                'trip_number' => 1003,
                'route_id' => 2,
                'car_id' => 3,
                'note' => 'this is trip note',
                'created_by' => 1,
                'updated_by' => 1
            ]);      
    }
}
