<?php

use Illuminate\Database\Seeder;
use App\Models\Settings\SettingArea;


class SettingAreaTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $data = SettingArea::query()->truncate();

        $data = new SettingArea;
        $data->division_id = 1; //Dhaka
        $data->district_id = 1; //Dhaka
        $data->name = 'যাত্রাবাড়ী';        
        $data->distance = 50;        
        $data->created_by = 1;        
        $data->save();

        $data = new SettingArea;
        $data->division_id = 1; //Dhaka
        $data->district_id = 1; //Dhaka
        $data->name = 'সাভার';        
        $data->distance = 90;        
        $data->created_by = 1;        
        $data->save();

        $data = new SettingArea;
        $data->division_id = 1; //Dhaka
        $data->district_id = 1; //Dhaka
        $data->name = 'ফার্মগেট';        
        $data->distance = 70;        
        $data->created_by = 1;        
        $data->save();
        
        $data = new SettingArea;
        $data->division_id = 2; //Dhaka
        $data->district_id = 1; //Dhaka
        $data->name = 'একে খান গেট';
        $data->distance = 120;       
        $data->created_by = 1;            
        $data->save();

        $data = new SettingArea;
        $data->division_id = 2; //Dhaka
        $data->district_id = 1; //Dhaka
        $data->name = 'অলংকার';
        $data->distance = 100;
        $data->created_by = 1;                
        $data->save();

        $data = new SettingArea;
        $data->division_id = 2; //Dhaka
        $data->district_id = 1; //Dhaka
        $data->name = 'চট্টগ্রাম বন্দর';
        $data->distance = 110;
        $data->created_by = 1;              
        $data->save();

    }
}