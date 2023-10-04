<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCapitalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('capitals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('code');
            $table->integer('invenstor_id')->nullable()->comment('primary key of Investors table');
            $table->tinyInteger('business_type')->comment('1 = Transport Business, 2 = Vehicle Business');
            $table->decimal('balance', 10, 2)->nullable();
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
        Schema::dropIfExists('capitals');
    }
}
