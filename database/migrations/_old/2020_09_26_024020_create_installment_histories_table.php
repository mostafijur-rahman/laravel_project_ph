<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstallmentHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('installment_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('code')->nullable();
            $table->integer('install_id')->comment('primary key of installments table')->unsigned();
            $table->date('pay_date')->nullable();
            $table->tinyInteger('pay_type')->nullable();
            $table->string('install_no')->nullable();
            $table->integer('pay_amount')->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('installment_histories');
    }
}
