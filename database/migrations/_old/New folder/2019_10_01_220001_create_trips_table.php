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
            // trip 
            $table->bigIncrements('id');
            $table->unsignedBigInteger('group_id')->nullable();
            $table->string('encrypt');
            $table->string('number')->nullable()->comment('trip number');
            $table->date('date')->comment('trip start date');
            $table->date('account_take_date')->nullable()->comment('trip account take date');
            $table->unsignedInteger('serial')->nullable()->comment('trip serial of this month');
            // $table->unsignedTinyInteger('stage')->default(1)->comment('1=running, 2=account taking step, 3=completed');

            // trip details
            $table->unsignedBigInteger('time_id')->comment('primary key of setting_vehilces_times table');
            $table->unsignedBigInteger('load_id')->comment('primary key of setting_areas table');
            $table->unsignedBigInteger('unload_id')->comment('primary key of setting_areas table');
            $table->unsignedBigInteger('distance')->nullable();
            $table->string('goods')->nullable();

            // company info (vehilce to this company)

            // company info (vehilce to this company)






            $table->unsignedBigInteger('vehicle_id')->comment('primary key of setting_vehilces table');
            $table->unsignedBigInteger('driver_id')->comment('primary key of setting_staffs table');

            // company details
            $table->unsignedBigInteger('company_id');
            $table->decimal('contract_fair', 10,2)->default(0);
            $table->decimal('advance_fair', 10,2)->default(0);
            $table->decimal('due_fair', 10,2)->default(0);
            $table->decimal('received_fair', 10,2)->default(0);
            $table->decimal('deduction_fair', 10,2)->default(0);
            $table->decimal('extend_fair', 10,2)->default(0);
            $table->text('deduction_extend_note')->nullable();
            $table->text('note')->nullable();

            // supplier details
            $table->unsignedBigInteger('supplier_id');
            $table->decimal('contract_fair', 10,2)->default(0);
            $table->decimal('advance_fair', 10,2)->default(0);
            $table->decimal('due_fair', 10,2)->default(0);
            $table->decimal('received_fair', 10,2)->default(0);
            $table->decimal('deduction_fair', 10,2)->default(0);
            $table->decimal('extend_fair', 10,2)->default(0);
            $table->text('deduction_extend_note')->nullable();
            $table->text('note')->nullable();

            // empty distance details
            $table->unsignedInteger('empty_distance')->nullable();
            $table->unsignedInteger('empty_load_id')->nullable()->comment('primary keys of setting_areas table');
            $table->unsignedInteger('empty_unload_id')->nullable()->comment('primary keys of setting_areas table');
            
            $table->unsignedInteger('created_by');
            $table->unsignedInteger('marketing_by')->nullable();
            $table->unsignedInteger('updated_by')->nullable();

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
        Schema::dropIfExists('trips');
    }
}
