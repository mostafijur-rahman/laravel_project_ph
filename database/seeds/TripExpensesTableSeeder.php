<?php

use Illuminate\Database\Seeder;

class TripExpensesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('trip_expenses')->truncate();
        DB::Table('trip_expenses')->insert([
                'te_encrypt' => 221,
                'td_id' => 1,
                'counter_id' => 1,
                'expense_id' => 1,
                'te_amount' => 100,
                'te_note' => 'panir bill',
                'created_by' => 1,
                'updated_by' => 1
            ]);
        DB::Table('trip_expenses')->insert([
                'te_encrypt' => 222,
                'td_id' => 1,
                'counter_id' => 2,
                'expense_id' => 2,
                'te_amount' => 200,
                'te_note' => 'guest',
                'created_by' => 1,
                'updated_by' => 1
            ]);
        DB::Table('trip_expenses')->insert([
                'te_encrypt' => 222,
                'td_id' => 1,
                'counter_id' => null,
                'expense_id' => 3,
                'te_amount' => 5000,
                'te_note' => 'oil',
                'created_by' => 1,
                'updated_by' => 1
            ]);
    
    }
}
