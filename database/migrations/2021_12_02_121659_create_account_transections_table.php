<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountTransectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_trans', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('encrypt');
            $table->unsignedBigInteger('investor_id')->nullable();
            $table->unsignedBigInteger('account_id');
            $table->enum('type', ['in','out']);
            $table->decimal('amount', 10,2);
            $table->string('status', 20);
            $table->date('date');            
            $table->nullableMorphs('transactionable');
            $table->mediumText('for')->nullable();
            $table->mediumText('note')->nullable();
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('account_trans');
    }
}