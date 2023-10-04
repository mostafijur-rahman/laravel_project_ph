<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameColumnOnSettingVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_vehicles', function (Blueprint $table) {
            $table->renameColumn('details', 'note');
            $table->renameColumn('vehicle_number', 'number_plate');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting_vehicles', function (Blueprint $table) {
            $table->renameColumn('note', 'details');
            $table->renameColumn('number_plate', 'vehicle_number');
        });
    }
}
