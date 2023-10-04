<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOnTripProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trip_providers', function (Blueprint $table) {
            $table->unsignedBigInteger('driver_id')->nullable()->after('vehicle_id');
            $table->unsignedBigInteger('helper_id')->nullable()->after('driver_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trip_providers', function (Blueprint $table) {
            $table->dropColumn(['driver_id', 'helper_id']);
        }); 
    }
}
