<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id')->index();

            // ekhane maybe shudhu supplier id rakha jabe own vehilce er khetre
            // $table->unsignedBigInteger('supplier_id');
            // $table->unsignedBigInteger('vehicle_id')->nullable();
            // $table->unsignedBigInteger('driver_id')->nullable();
            // $table->unsignedBigInteger('owner_id')->nullable();
            // $table->unsignedBigInteger('reference_id')->nullable();

            // basic
            $table->enum('ownership', ['out','own']);
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->string('vehicle_number', 50)->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_phone')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('owner_phone')->nullable();
            $table->string('reference_name')->nullable();
            $table->string('reference_phone')->nullable();
            // accounts
            $table->decimal('contract_fair', 10,2)->default(0);
            $table->decimal('advance_fair', 10,2)->default(0);
            $table->decimal('received_fair', 10,2)->default(0);
            $table->decimal('due_fair', 10,2)->default(0);
            $table->decimal('deduction_fair', 10,2)->default(0);
            $table->decimal('extend_fair', 10,2)->default(0);
            $table->decimal('demarage', 10,2)->default(0);
            $table->decimal('demarage_received', 10,2)->default(0);
            $table->decimal('demarage_due', 10,2)->default(0);
            
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('trip_id')->references('id')->on('trips')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trip_vehicle_providers');
    }
}
