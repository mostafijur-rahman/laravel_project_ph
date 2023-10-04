<?php

use Illuminate\Database\Seeder;

class SettingBrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('setting_brands')->insert([
            [
                'sort' => '0',
                'name' => 'Eicher',
            ],
            [
                'sort' => '1',
                'name' => 'TATA',
            ],
            [
                'sort' => '2',
                'name' => 'OshokLay land',
            ],
        ]);
    }
}
