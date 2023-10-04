<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTyresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tyres', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('encrypt');
            // $table->unsignedBigInteger('purchase_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('tyre_number')->unique();
            $table->decimal('warranty_km', 10, 2)->nullable();

            // vehicle info
            $table->unsignedBigInteger('vehicle_id')->nullable();
            $table->date('attach_date')->nullable();
            $table->unsignedBigInteger('position_id')->nullable();

            // notification
            $table->decimal('notify_km', 10, 2)->nullable();
            $table->date('notify_date', 10, 2)->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tyres');
    }
}
