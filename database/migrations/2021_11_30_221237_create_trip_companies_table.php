<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTripCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trip_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('trip_id');
            $table->unsignedBigInteger('company_id');
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
        Schema::dropIfExists('trip_companies');
    }
}
