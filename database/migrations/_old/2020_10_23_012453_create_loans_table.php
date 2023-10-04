<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->comment('transection date');
            $table->unsignedInteger('client_id')->comment('primary key of users table');
            $table->decimal('cash_in', 10, 2)->nullable();
            $table->decimal('cash_out', 10, 2)->nullable();
            $table->decimal('balance', 10, 2)->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('created_by');
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
        Schema::dropIfExists('loans');
    }
}
