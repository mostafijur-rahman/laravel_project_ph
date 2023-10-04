<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVoucherIdOnTripOilExpensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trip_oil_expenses', function (Blueprint $table) {
            $table->string('voucher_id')->nullable()->after('pump_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trip_oil_expenses', function (Blueprint $table) {
            $table->dropColumn('voucher_id');
        });  
    }
}
