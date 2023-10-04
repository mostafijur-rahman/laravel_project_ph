<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOnSettingVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_vehicles', function (Blueprint $table) {

            $table->string('ownership', 50)->nullable()->after('encrypt');
            $table->unsignedBigInteger('manufacturer_id')->nullable()->after('model');
            $table->string('body_type', 50)->nullable()->after('manufacturer_id');
            $table->string('engine_down', 50)->nullable()->after('body_type');
            $table->decimal('fuel_tank_capacity', 10, 2)->nullable()->after('engine_down');
            $table->string('gps_id')->nullable()->after('fuel_tank_capacity');

            $table->string('registration_year', 10)->nullable()->after('gps_id');
            $table->date('tax_token_expire_date')->nullable()->after('registration_year');
            $table->date('fitness_expire_date')->nullable()->after('tax_token_expire_date');
            $table->date('insurance_expire_date')->nullable()->after('fitness_expire_date');
            $table->date('last_tyre_change_date')->nullable()->after('insurance_expire_date');
            $table->date('last_mobil_change_date')->nullable()->after('last_tyre_change_date');
            $table->date('last_servicing_date')->nullable()->after('last_mobil_change_date');

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

            $table->dropColumn('ownership');
            $table->dropColumn('manufacturer_id');
            $table->dropColumn('body_type');
            $table->dropColumn('engine_down');
            $table->dropColumn('fuel_tank_capacity');
            $table->dropColumn('gps_id');

            $table->dropColumn('registration_year');
            $table->dropColumn('tax_token_expire_date');
            $table->dropColumn('fitness_expire_date');
            $table->dropColumn('insurance_expire_date');
            $table->dropColumn('last_tyre_change_date');
            $table->dropColumn('last_mobil_change_date');
            $table->dropColumn('last_servicing_date');
            
        });
    }
}
