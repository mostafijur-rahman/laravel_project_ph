<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingAreasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_areas', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('division_id')->unsigned()->nullable()->comment('primary key of setting_divisions table');
            $table->integer('district_id')->unsigned()->nullable()->comment('primary key of setting_districts table');
            $table->string('name')->nullable();
            $table->integer('distance')->default(0);
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
        Schema::dropIfExists('setting_areas');
    }
}
