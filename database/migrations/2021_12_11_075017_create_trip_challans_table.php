<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripChallansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_challans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id')->index();
            $table->unsignedBigInteger('account_transection_id')->index();
            $table->enum('for', ['provider_trip','company_trip','provider_demarage','company_demarage']);
            $table->date('date');
            $table->decimal('amount',10,2);
            $table->string('recipients_name')->nullable();
            $table->string('recipients_phone')->nullable();
            $table->mediumText('note')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('account_transection_id')->references('id')->on('account_trans')->onDelete('cascade');
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
        Schema::dropIfExists('trip_challans');
    }
}
