<?php

use Illuminate\Database\Seeder;

class SettingDefaultTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('setting_defaults')->truncate();
        DB::Table('setting_defaults')->insert([
            [
                'key' => 'company_name',
                'value' => 'পরিবহন হিসাব',
            ],
            [
                'key' => 'slogan',
                'value' => '',
            ],
            [
                'key' => 'address',
                'value' => 'মুক্তবাংলা শপিং, মিরপুর - ১, ঢাকা - ১২১৬',
            ],
            [
                'key' => 'phone',
                'value' => '০১৭১৪০৭৮৭৪৩',
            ],
            [
                'key' => 'email',
                'value' => 'paribahanhishab@gmail.com',
            ],
            [
                'key' => 'website',
                'value' => 'www.paribahanhishab.com',
            ],
            [
                'key' => 'logo',
                'value' => 'default_logo.svg',
            ],
            [
                'key' => 'favicon',
                'value' => 'default_favicon.png',
            ],
            [
                'key' => 'module',
                'value' => '1,2,3,4,5,6,7,8,9',
            ],
            [
                'key' => 'oil_rate',
                'value' => '80',
            ],
            [
                'key' => 'transport_booking_time',
                'value' => '0',
            ],
            [
                'key' => 'transport_booking_distance',
                'value' => '0',
            ],
            [
                'key' => 'transport_expense',
                'value' => '0',
            ],
            [
                'key' => 'trip_booking_time',
                'value' => '0',
            ],
            [
                'key' => 'trip_booking_distance',
                'value' => '0',
            ],
            [
                'key' => 'trip_booking_distance_calculation',
                'value' => '0',
            ],
            [
                'key' => 'trip_stage',
                'value' => '0',
            ],
            [
                'key' => 'meghna_bridge_distance_show',
                'value' => '0',
            ], 
        ]);


        // setting
        DB::table('settings')->truncate();
        DB::Table('settings')->insert([

            // general
            [
                'key' => 'client_system.default_challan',
                'value' => 'own_vehicle_single',
            ],
            [
                'key' => 'client_system.company_name',
                'value' => 'পরিবহন হিসাব',
            ],
            [
                'key' => 'client_system.slogan',
                'value' => 'পণ্য পরিবহনে আমরা এক ধাপ এগিয়ে',
            ],
            [
                'key' => 'client_system.address',
                'value' => 'মুক্তবাংলা শপিং, মিরপুর - ১, ঢাকা - ১২১৬',
            ],
            [
                'key' => 'client_system.phone',
                'value' => '01714078743',
            ],
            [
                'key' => 'client_system.email',
                'value' => 'paribahanhishab@gmail.com',
            ],
            [
                'key' => 'client_system.website',
                'value' => 'www.paribahanhishab.com',
            ],
            [
                'key' => 'client_system.oil_rate',
                'value' => 135,
            ],

            // image
            [
                'key' => 'client_system.favicon',
                'value' => false,
            ],
            [
                'key' => 'client_system.logo',
                'value' => false,
            ],

            // notifcation
            [
                'key' => 'client_system.notify_days_for_document',
                'value' => 15,
            ],
            [
                'key' => 'client_system.notify_days_for_mobil',
                'value' => 15,
            ],
            [
                'key' => 'client_system.notify_days_for_tyre',
                'value' => 15,
            ],

            // for admin
            [
                'key' => 'admin_system.zero_balance_transection',
                'value' => true, // can transection with 0 balance
            ],

            // for admin billing
            [
                'key' => 'admin_system.business_type',
                'value' => 'own_vehilce', // only_own_vehilce, only_comission, own_vehilce_and_comission
            ],
            [
                'key' => 'admin_system.max_own_vehicle_qty',
                'value' => 5,
            ],
            [
                'key' => 'admin_system.max_challan_qty_per_month',
                'value' => 1000,
            ],
            [
                'key' => 'admin_system.last_date_of_bill_payment',
                'value' => null,
            ],
            [
                'key' => 'admin_system.total_bill',
                'value' => 0,
            ],
            [
                'key' => 'admin_system.notify_days_for_bill',
                'value' => 7,
            ],
            [
                'key' => 'admin_system.due_payment_action',
                'value' => 'warning', // warning, lock
            ],



            
        ]);

    }
}
