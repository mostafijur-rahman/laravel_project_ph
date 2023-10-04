<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripMetersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_meters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('encrypt');
            $table->unsignedInteger('vehicle_id')->nullable();
            $table->unsignedInteger('trip_id')->nullable();
            $table->decimal('previous_reading',10,2)->default(0);
            $table->decimal('current_reading',10,2)->default(0);

            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_meters');
    }
}
