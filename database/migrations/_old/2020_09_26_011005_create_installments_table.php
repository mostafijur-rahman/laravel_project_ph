<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->date('buy_date')->nullable();
            $table->integer('providers_id')->comment('primary key of vehicle providers table')->unsigned();
            $table->string('car_id')->nullable();
            $table->integer('chassis_price')->nullable();
            $table->integer('interest_percent')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('total_price')->nullable();
            $table->integer('down_payment')->nullable();
            $table->integer('install_number')->nullable();
            $table->integer('install_amount')->nullable();
            $table->date('install_pay_start_date')->nullable();
            $table->date('install_pay_end_date')->nullable();
            $table->integer('created_by')->comment('primary key of user table')->unsigned();
            $table->integer('updated_by')->comment('primary key of user table')->unsigned();
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
        Schema::dropIfExists('installments');
    }
}
