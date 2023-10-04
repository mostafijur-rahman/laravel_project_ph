<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call(UsersTableSeeder::class);  // for new client
        $this->call(SettingSuppliersTableSeeder::class);
        $this->call(SettingDesignationsTableSeeder::class); // for new client
        $this->call(SettingStaffsTableSeeder::class);
        $this->call(SettingVehicleTypeTableSeeder::class);
        $this->call(SettingVehicleTableSeeder::class);
        $this->call(SettingCompanyTableSeeder::class);
        $this->call(SettingExpenseTableSeeder::class);
        $this->call(SettingDefaultTableSeeder::class);  // for new client

        $this->call(SettingPumpTableSeeder::class);

        $this->call(SettingTimeSheetsTableSeeder::class); // for new client
        $this->call(SettingAreaTableSeeder::class);
        $this->call(SettingDivisionsTableSeeder::class); // for new client

        $this->call(SettingProvidersTableSeeder::class);

        // // $this->call(InvenstorSeeder::class); // previous hide

        $this->call(SettingBrandsTableSeeder::class);
        $this->call(SettingInvestorsTableSeeder::class);
        $this->call(UserPositionsTableSeeder::class); // for new client
        $this->call(SettingBankTableSeeder::class);
        $this->call(AccountTableSeeder::class);
        $this->call(SettingUnitTableSeeder::class);
        $this->call(AccountTransTableSeeder::class);
    }
}
