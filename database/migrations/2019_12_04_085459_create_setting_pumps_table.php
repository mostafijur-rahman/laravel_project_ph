<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingPumpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_pumps', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('sort')->default(0);
            $table->string('encrypt')->nullable();
            $table->string('name');
            $table->decimal('receivable_amount', 10, 2)->default(0);
            $table->decimal('payable_amount', 10, 2)->default(0);
            $table->text('note')->nullable();
            $table->unsignedInteger('created_by')->comment('primary key of users table');
            $table->unsignedInteger('updated_by')->nullable()->comment('primary key of users table');
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
        Schema::dropIfExists('pumps');
    }
}
