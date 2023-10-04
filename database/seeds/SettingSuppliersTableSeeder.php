<?php

use Illuminate\Database\Seeder;

class SettingSuppliersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('setting_suppliers')->insert([
            [
                'encrypt' => uniqid(),
                'type' => 'vehicle',
                'name' => 'একতা ট্রান্সপোর্ট',
            ],
            [
                'encrypt' => uniqid(),
                'type' => 'vehicle',
                'name' => 'রহিম ভাই',
            ],
            [
                'encrypt' => uniqid(),
                'type' => 'goods',
                'name' => 'আজাদ ষ্টোর',
            ],
            [
                'encrypt' => uniqid(),
                'type' => 'goods',
                'name' => 'যমুনা ষ্টোর',
            ],
        ]);
    }
}
