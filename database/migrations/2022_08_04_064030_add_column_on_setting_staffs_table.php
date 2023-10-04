<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnOnSettingStaffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('setting_staffs', function (Blueprint $table) {

            $table->string('gender', 50)->nullable()->after('sort');
            $table->string('email')->nullable()->after('phone');
            $table->date('dob')->after('permanent_address');
            $table->string('blood_group', 10)->nullable()->after('dob');
            $table->string('company_id')->nullable()->after('blood_group');
            
            $table->string('passport_number')->nullable()->after('license_number');
            $table->string('birth_certificate_number')->nullable()->after('passport_number');
            $table->string('port_id')->nullable()->after('birth_certificate_number');
            $table->unsignedBigInteger('bank_id')->nullable()->after('port_id');
            $table->string('bank_account_number')->nullable()->after('bank_id');
            $table->decimal('salary_amount', 10, 2)->nullable()->after('bank_account_number');

            $table->string('reference_name')->nullable()->after('salary_amount');
            $table->string('reference_phone')->nullable()->after('reference_name');
            $table->string('reference_nid_number')->nullable()->after('reference_phone');
            $table->string('reference_present_address')->nullable()->after('reference_nid_number');
            
            $table->renameColumn('license_number', 'driving_license_number');    
            $table->renameColumn('details', 'note');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('setting_staffs', function (Blueprint $table) {
            $table->dropColumn('gender');
            $table->dropColumn('email');
            $table->dropColumn('dob');
            $table->dropColumn('blood_group');
            $table->dropColumn('company_id');

            $table->dropColumn('passport_number');
            $table->dropColumn('birth_certificate_number');
            $table->dropColumn('port_id');
            $table->dropColumn('bank_id');
            $table->dropColumn('bank_account_number');
            $table->dropColumn('salary_amount');
            $table->dropColumn('reference_name');
            $table->dropColumn('reference_phone');
            $table->dropColumn('reference_nid_number');
            $table->dropColumn('reference_present_address');

            $table->renameColumn('driving_license_number', 'license_number');
            $table->renameColumn('note', 'details');
            
        });
    }
}
