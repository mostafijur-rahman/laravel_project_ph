<?php

use Illuminate\Database\Seeder;

class SettingTimeSheetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_time_sheets')->truncate();
        DB::Table('setting_time_sheets')->insert([
            // 'time' => '০৭:৩০ সকাল',
            [
                'time' => '০৫:০০ ভোর',
            ],
            [
                'time' => '০৬:০০ ভোর',
            ],
            [
                'time' => '০৭:০০ সকাল',
            ],
            [
                'time' => '০৮:০০ সকাল',
            ],
            [
                'time' => '০৯:০০ সকাল',
            ],
            [
                'time' => '১০:০০ সকাল',
            ],
            [
                'time' => '১১:০০ সকাল',
            ],
            [
                'time' => '১২:০০ সকাল',
            ],
            [
                'time' => '০১:০০ দুপুর',
            ],
            [
                'time' => '০২:০০ দুপুর',
            ],
            [
                'time' => '০৩:০০ দুপুর',
            ],
            [
                'time' => '০৪:০০ বিকাল',
            ],
            [
                'time' => '০৫:০০ বিকাল',
            ],
            [
                'time' => '০৬:০০ সন্ধ্যা',
            ],
            [
                'time' => '০৭:০০ সন্ধ্যা',
            ],
            [
                'time' => '০৮:০০ রাত',
            ],
            [
                'time' => '০৯:০০ রাত',
            ],
            [
                'time' => '১০:০০ রাত',
            ],
            [
                'time' => '১১:০০ রাত',
            ],
            [
                'time' => '১২:০০ রাত',
            ],
            [
                'time' => '০১:০০ রাত',
            ],
            [
                'time' => '০২:০০ রাত',
            ],
            [
                'time' => '০৩:০০ রাত',
            ],
            [
                'time' => '০৪:০০ রাত',
            ]
        ]);
    }

}