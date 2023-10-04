<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingInvestorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('setting_investors')->insert([
            [
                'sort' => '0',
                'name' => 'নিজ',
            ],
            [
                'sort' => '1',
                'name' => 'ইনভেস্টর নাম ১',
            ],
            [
                'sort' => '2',
                'name' => 'ইনভেস্টর নাম ২',
            ]
        ]);
    }
}
