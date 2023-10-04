<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('encrypt');
            $table->morphs('purchaseable');
            $table->unsignedBigInteger('supplier_id')->nullable();

            $table->date('date');
            $table->decimal('price',10,2)->default(0);
            $table->decimal('paid',10,2)->default(0);
            $table->decimal('due',10,2)->nullable()->default(0);
            $table->decimal('discount',10,2)->nullable()->default(0);

            $table->text('note')->nullable();
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
        Schema::dropIfExists('purchases');
    }
}
