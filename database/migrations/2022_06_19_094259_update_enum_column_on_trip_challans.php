<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateEnumColumnOnTripChallans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement("ALTER TABLE `trip_challans` CHANGE `for` `for` ENUM('provider_trip','company_trip','provider_demarage','company_demarage','cash_comission')");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("ALTER TABLE `trip_challans` CHANGE `for` `for` ENUM('provider_trip','company_trip','provider_demarage','company_demarage')");
    }
}
