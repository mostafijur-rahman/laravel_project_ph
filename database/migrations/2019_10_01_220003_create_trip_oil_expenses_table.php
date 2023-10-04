<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripOilExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_oil_expenses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('encrypt');
            $table->unsignedInteger('vehicle_id')->nullable();
            $table->unsignedInteger('trip_id')->nullable()->comment('if trip id not exist then this oil bill not from a trip');
            $table->unsignedInteger('pump_id')->nullable();
            $table->decimal('liter',10,2)->default(0);
            $table->decimal('rate',10,2)->default(0);
            $table->decimal('bill',10,2)->default(0);
            $table->date('date');
            $table->text('note')->nullable();
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
        Schema::dropIfExists('trip_oil_expenses');
    }
}
