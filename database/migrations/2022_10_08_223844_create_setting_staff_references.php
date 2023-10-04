<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingStaffReferences extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_staff_references', function (Blueprint $table) {

            $table->bigIncrements('id');

            $table->unsignedBigInteger('staff_id')->index();
            $table->string('referrer')->nullable();
            $table->string('relation', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('nid_number', 20)->nullable();
            $table->string('address')->nullable();
            $table->boolean('main_referrer')->default(0);

            $table->unsignedInteger('created_by');
            $table->unsignedInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('staff_id')->references('id')->on('setting_staffs')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('setting_staff_references');
    }
}
