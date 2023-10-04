<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapitalHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capital_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('code');
            $table->date('date');
            $table->integer('capital_id')->unsigned()->comment('primary key of capitals table');
            $table->tinyInteger('business_type')->comment('1 = Transport Business, 2 = Vehicle Business');
            $table->unsignedInteger('vehicle_id')->nullable()->comment('primary key of cars table');
            $table->decimal('cash_in', 10, 2)->nullable();
            $table->decimal('cash_out', 10, 2)->nullable();
            $table->text('note')->nullable();
            $table->integer('created_by')->comment('primary key of users table');
            $table->integer('updated_by')->comment('primary key of users table');
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
        Schema::dropIfExists('capital_histories');
    }
}
