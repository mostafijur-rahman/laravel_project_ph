<?php

use Illuminate\Database\Seeder;
use App\Models\User\Role;

class UserPositionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::query()->truncate();

        $data = new Role;
        $data->name = 'Admin';   
        $data->read = 1;   
        $data->create = 1;   
        $data->edit = 1;   
        $data->delete = 1;   
        $data->created_by = 1;        
        $data->save();

        $data = new Role;
        $data->name = 'Manager';   
        $data->read = 1;   
        $data->create = 1;
        $data->edit = 1;
        $data->created_by = 1;
        $data->save();

        $data = new Role;
        $data->name = 'Operator';   
        $data->created_by = 1;    
        $data->save();

    }
}