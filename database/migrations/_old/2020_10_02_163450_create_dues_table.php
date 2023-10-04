<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dues', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('encrypt');
            $table->date('date');
            $table->string('table_name')->commet('which type of dues');
            $table->integer('table_id')->unsigned();
            $table->string('client_id')->comment('primary key of client table')->nullable();
            $table->decimal('amount', 10,2)->comment('due amount')->nullable();
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
        Schema::dropIfExists('dues');
    }
}
