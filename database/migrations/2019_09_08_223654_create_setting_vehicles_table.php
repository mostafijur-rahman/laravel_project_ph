<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('sort')->default(0);
            $table->string('encrypt')->nullable();
            $table->string('vehicle_serial')->nullable();
            $table->string('vehicle_number')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('engine_number')->nullable();
            $table->string('chassis_number')->nullable();
            $table->string('model')->nullable();
            $table->text('details')->nullable();
            
            $table->unsignedBigInteger('supplier_id')->nullable()->index()->comment('primary key of setting_suppliers table');
            $table->unsignedBigInteger('driver_id')->nullable()->index()->comment('primary key of setting_staffs table');
            $table->unsignedBigInteger('helper_id')->nullable()->index()->comment('primary key of setting_staffs table');
            $table->unsignedBigInteger('vehicle_type_id')->nullable()->index()->comment('primary key of setting_vehicle_types table');
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('supplier_id')->references('id')->on('setting_suppliers')->onDelete('cascade');
            $table->foreign('driver_id')->references('id')->on('setting_staffs')->onDelete('cascade');
            $table->foreign('helper_id')->references('id')->on('setting_staffs')->onDelete('cascade');
            $table->foreign('vehicle_type_id')->references('id')->on('setting_vehicle_types')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_vehicles');
    }
}
