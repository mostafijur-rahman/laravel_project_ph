<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDueCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('due_collections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('encrypt');
            $table->string('business')->comment('trip,transport');
            $table->date('date');
            $table->unsignedBigInteger('company_id');
            $table->decimal('amount', 10, 2)->comment('due amount');
            $table->text('amount_history')->comment('json array from trip table');
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
        Schema::dropIfExists('due_collections');
    }
}
