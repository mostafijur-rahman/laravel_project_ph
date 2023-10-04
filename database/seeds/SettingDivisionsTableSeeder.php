<?php

use Illuminate\Database\Seeder;
use App\Models\Settings\SettingDivision;

class SettingDivisionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = SettingDivision::query()->truncate();

        $data = new SettingDivision;
        $data->name = 'ঢাকা';        
        $data->status = 1;        
        // $data->name_bn = 'ঢাকা';
        $data->save();

        $data = new SettingDivision;
        $data->name = 'চট্টগ্রাম';
        $data->status = 1;      
        $data->save();

        $data = new SettingDivision;
        $data->name = 'রাজশাহী';
        $data->status = 1;     
        $data->save();

        $data = new SettingDivision;
        $data->name = 'খুলনা';
        $data->status = 1;   
        $data->save();

        $data = new SettingDivision;
        $data->name = 'বরিশাল';
        $data->status = 1;      
        $data->save();

        $data = new SettingDivision;
        $data->name = 'সিলেট';
        $data->status = 1;       
        $data->save();

        $data = new SettingDivision;
        $data->name = 'রংপুর';
        $data->status = 1;      
        $data->save();

        $data = new SettingDivision;
        $data->name = 'ময়মনসিংহ';
        $data->status = 1;    
        $data->save();

    }
}