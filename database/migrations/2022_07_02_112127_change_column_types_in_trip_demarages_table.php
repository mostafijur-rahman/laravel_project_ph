<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeColumnTypesInTripDemaragesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('trip_demarages', function (Blueprint $table) {
            $table->decimal('company_amount', 10,2)->nullable()->default(0)->change();
            $table->decimal('provider_amount', 10,2)->nullable()->default(0)->change();
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::table('trip_demarages', function (Blueprint $table) {
            $table->decimal('company_amount',10,2);
            $table->decimal('provider_amount',10,2);
        });

    }
}
