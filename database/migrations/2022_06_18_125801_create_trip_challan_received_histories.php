<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripChallanReceivedHistories extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_challan_received_histories', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->unsignedBigInteger('trip_id')->index();
            $table->date('received_date');
            $table->string('receiver_name');
            $table->mediumText('note')->nullable();

            // other
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('trip_challan_received_histories');
    }
}
