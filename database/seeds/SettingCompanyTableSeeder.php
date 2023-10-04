<?php

use Illuminate\Database\Seeder;

class SettingCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('setting_companies')->insert([
            [
                'encrypt' => uniqid(),
                'name' => 'বসুন্ধরা গ্রুপ',
                'phone' => '01714078743',
            ],
            [
                'encrypt' => uniqid(),
                'name' => 'আকিজ গ্রুপ',
                'phone' => '01714078743',
            ],
            [
                'encrypt' => uniqid(),
                'name' => 'যমুনা গ্রুপ',
                'phone' => '01714078743',
            ],
            [
                'encrypt' => uniqid(),
                'name' => 'নাম জানা নেই',
                'phone' => '01714078743',
            ]
        ]);
    }

    



}
