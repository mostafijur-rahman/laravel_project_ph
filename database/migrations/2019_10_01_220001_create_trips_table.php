<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('trips', function (Blueprint $table) {
            // primary info
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('encrypt');
            $table->string('number')->nullable()->comment('trip number');
            $table->date('date')->comment('trip start date');
            $table->date('account_take_date')->nullable()->comment('trip account take date');
            $table->unsignedTinyInteger('serial')->nullable()->comment('trip serial of this month');
            // trip info
            $table->unsignedTinyInteger('time_id')->nullable();
            $table->unsignedInteger('box')->nullable();
            $table->decimal('weight',10,2)->nullable();
            $table->unsignedTinyInteger('unit_id')->nullable();
            $table->string('goods')->nullable();
            $table->mediumText('note')->nullable();
            // other
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // index implement
            // relation define
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('trips');
    }
}
