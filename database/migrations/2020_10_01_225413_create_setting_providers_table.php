<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingProvidersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_providers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('encrypt');
            $table->unsignedInteger('sort')->default(0);
            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('note')->nullable();
            $table->unsignedInteger('created_by')->comment('primary key of users table');
            $table->unsignedInteger('updated_by')->comment('primary key of users table');
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
        Schema::dropIfExists('setting_providers');
    }
}
