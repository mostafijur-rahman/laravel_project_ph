<?php

use Illuminate\Database\Seeder;

class SettingExpenseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('setting_expenses')->insert([

            
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 1,
                'head' => 'খোরাকী',
                'sort' => '1',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 1,
                'head' => 'ব্রীজ ভাড়া',
                'sort' => '2',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 1,
                'head' => 'লেবার',
                'sort' => '3',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 1,
                'head' => 'চাঁদা/দারোয়ান',
                'sort' => '4',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 1,
                'head' => 'পুলিশ',
                'sort' => '5',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 1,
                'head' => 'কমিশন',
                'sort' => '9',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 1,
                'head' => 'অন্যান',
                'sort' => '6',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 1,
                'head' => 'সার্ভিসিং',
                'sort' => '6',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 1,
                'head' => 'বালতি',
                'sort' => '6',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 2,
                'head' => 'কন্টেইনার',
                'sort' => '7',
                'created_by' => 1,
                'updated_by' => 1,
            ],
            [
                'encrypt' => uniqid(),
                'expense_type_id' => 2,
                'head' => 'টায়ার',
                'sort' => '8',
                'created_by' => 1,
                'updated_by' => 1,
            ],
        ]);
    }
}
