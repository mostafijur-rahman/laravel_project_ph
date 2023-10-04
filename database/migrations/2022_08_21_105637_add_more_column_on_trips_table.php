<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMoreColumnOnTripsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->string('buyer_name')->nullable()->after('goods');
            $table->string('buyer_code')->nullable()->after('buyer_name');
            $table->string('order_no')->nullable()->after('buyer_code');
            $table->decimal('depu_change_bill', 10, 2)->nullable()->after('order_no');
            $table->string('gate_pass_no')->nullable()->after('depu_change_bill');
            $table->string('lock_no')->nullable()->after('gate_pass_no');
            $table->string('load_point_reach_time')->nullable()->after('lock_no');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('trips', function (Blueprint $table) {
            $table->dropColumn(['buyer_name', 'buyer_code', 'order_no', 'depu_change_bill', 'gate_pass_no', 'lock_no', 'load_point_reach_time']);
        });
    }
}
