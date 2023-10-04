<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOnSettingPumpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_pumps', function (Blueprint $table) {
            $table->string('phone')->nullable()->after('name');
            $table->mediumText('address')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting_pumps', function (Blueprint $table) {
            $table->dropColumn(['phone', 'address']);
        });  
    }
}
