<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // DB::table('users')->truncate();
        DB::Table('users')->insert([
            'first_name' => 'মোস্তাফিজুর',
            'last_name' => 'রহমান',
            'email' => 'mostafij@gmail.com',
            'password' => bcrypt('313583'),
            'role_id' => 1,
            'status' => 'active',
            'created_by' => 1,
        ]);
        // DB::Table('users')->insert([
        //     'first_name' => 'কাসেম',
        //     'last_name' => '',
        //     'email' => 'kashem@gmail.com',
        //     'password' => bcrypt('123456'),
        //     'role_id' => 1,
        //     'status' => 'active',
        //     'created_by' => 1,
        // ]);
        DB::Table('users')->insert([
            'first_name' => 'admin',
            'last_name' => '',
            'email' => 'admin@test.com',
            'password' => bcrypt('123456'),
            'role_id' => 1,
            'status' => 'active',
            'created_by' => 1,
        ]);
        // DB::Table('users')->insert([
        //     'first_name' => 'Operator',
        //     'last_name' => 'Name',
        //     'email' => 'operator@test.com',
        //     'password' => bcrypt('1'),
        //     'role_id' => 3,
        //     'status' => 'active',
        //     'created_by' => 1,
        // ]);
    }
}