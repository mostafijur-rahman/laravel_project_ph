<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccountsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accounts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('sort')->default(0);
            $table->enum('type', ['bank','cash']);
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('holder_name')->nullable();
            $table->string('user_name')->nullable();
            $table->string('account_number')->nullable();
            $table->decimal('balance', 10,2)->default(0);
            $table->mediumText('note')->nullable();
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
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
        Schema::dropIfExists('accounts');
    }
}
