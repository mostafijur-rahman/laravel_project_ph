<?php

use Illuminate\Database\Seeder;

class IncomesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('incomes')->truncate();
        DB::Table('incomes')->insert([
            ['income_name' => 'পার্সেল'],
            ['income_name' => 'যাত্রী'],
            ['income_name' => 'অতিরিক্ত মাল'],
        ]);
    }
}
