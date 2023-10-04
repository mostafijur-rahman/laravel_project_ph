<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('setting_companies', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('encrypt')->nullable();
            $table->unsignedInteger('sort')->default(0);

            // $table->decimal('advance_received', 10, 2)->default(0);
            // $table->decimal('total_dues', 10, 2)->default(0);

            $table->string('name');
            $table->string('phone')->nullable();
            $table->text('address')->nullable();
            $table->text('note')->nullable();

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
        Schema::dropIfExists('setting_companies');
    }
}
