<?php

use Illuminate\Database\Seeder;

class SettingPumpTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_pumps')->truncate();
        DB::Table('setting_pumps')->insert([
            [
                'encrypt' => uniqid(),
                'name' => 'মেসার্স আকসার এন্ড ব্রাদার্স',
                'created_by' => 1,
             ],
             [
                'encrypt' => uniqid(),
                'name' => 'বিসমিল্লাহ ফিলিং স্টেশন',
                'created_by' => 1,
             ],
        ]);
    }
}
