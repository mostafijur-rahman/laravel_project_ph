<?php

use Illuminate\Database\Seeder;
use App\Models\Settings\SettingProvider;


class SettingProvidersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = SettingProvider::query()->truncate();

        $data = new SettingProvider;
        $data->sort = 0;     
        $data->name = 'TATA MOTORS Ltd (NITOL MOTORS)';
        $data->created_by = 1;      
        $data->updated_by = 1;       
        $data->save();

        $data = new SettingProvider;
        $data->sort = 0;      
        $data->name = 'EICHER (RUNNER MOTORS LTD)';
        $data->created_by = 1;     
        $data->updated_by = 1; 
        $data->save();

        $data = new SettingProvider;
        $data->sort = 0;      
        $data->name = 'ASHOK LEYLAND (IFAD AUTO Ltd)';
        $data->created_by = 1;     
        $data->updated_by = 1; 
        $data->save();
    }
}
