<?php

use Illuminate\Database\Seeder;

class SettingStaffsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::Table('setting_staffs')->insert([
            [
                'encrypt' => uniqid(),
                'name' => 'সোহরাব হোসেন',
                'designation_id' => 1,
                'phone' => '01714078743',
                'present_address' => 'বাসা নং - ৩৬, রোড নং - ১২, মিরপুর-১, ঢাকা-১২১৬',
            ],
            [
                'encrypt' => uniqid(),
                'name' => 'হুমায়ুন কবির',
                'designation_id' => 1,
                'phone' => '01714078743',
                'present_address' => 'বাসা নং - ৩৬, রোড নং - ১২, মিরপুর-১, ঢাকা-১২১৬',
            ],
            [
                'encrypt' => uniqid(),
                'name' => '	রফিক',
                'designation_id' => 2,
                'phone' => '01714078743',
                'present_address' => 'বাসা নং - ৩৬, রোড নং - ১২, মিরপুর-১, ঢাকা-১২১৬',
            ],
            [
                'encrypt' => uniqid(),
                'name' => '	কালাম',
                'designation_id' => 2,
                'phone' => '01714078743',
                'present_address' => 'বাসা নং - ৩৬, রোড নং - ১২, মিরপুর-১, ঢাকা-১২১৬',
            ],
        ]);
    }
}
