<?php


// URL::forceScheme('https');
Auth::routes(['register' => false, 'password.request' => false, 'reset' => false]);

Route::get('/', function(){
    return redirect('/login');
});

Route::get('locale/{lang_type}', function($lang_type) {
	Session::put('locale', $lang_type);
	return redirect()->back();
});

Route::middleware(['auth'])->group(function(){

    // system setup
    Route::get('/init-config', 'SystemSetupController@index');
    Route::post('/save-init-config', 'SystemSetupController@saveInitConfig');

    // primary route
    Route::get('dashboard', 'DashboardController@index');
    Route::get('vehicle-tracking', 'DashboardController@vehicle_tracking');
    
    Route::get('help','DashboardController@help');
    Route::get('cash-memory-clear','DashboardController@cashMemoryClear');

    // Profile Releate
    Route::get('profile','DashboardController@profile');
    Route::post('profile/personal-info','DashboardController@profile_update');
    Route::post('profile/change-password','DashboardController@change_password');

    /* ------------------------------------------
    / trip module
    ------------------------------------------ */
    Route::get('trips', 'Trip\TripController@index');

    Route::prefix('trips')->group(function () {

        Route::resource('out-commission-transection', 'Trip\OutCommissionTransection');
        Route::put('out-commission-transection', 'Trip\OutCommissionTransection@update');

        Route::resource('out-nagad-commission', 'Trip\OutNagadCommission');
        Route::put('out-nagad-commission', 'Trip\OutNagadCommission@update');

        Route::resource('own-vehicle-single', 'Trip\OwnVehicleSingle');
        Route::put('own-vehicle-single', 'Trip\OwnVehicleSingle@update');

        Route::resource('own-vehicle-up-down', 'Trip\OwnVehicleUpDown');
        Route::put('own-vehicle-up-down', 'Trip\OwnVehicleUpDown@update');
        Route::get('own-vehicle-up-down-report', 'Trip\OwnVehicleUpDown@report');

        Route::post('challan-received', 'Trip\TripChallanReceivedController@store');
        Route::delete('challan-received/{id}', 'Trip\TripChallanReceivedController@destroy');

        Route::get('get-driver-and-helper-id/{vehicleId}', 'Trip\OwnVehicleSingle@getDriverAndHelperId');
        Route::get('unique-challan-validation/{challanNumber}', 'Trip\OwnVehicleSingle@uniqueChallanValidation');

        // demurrage
        Route::post('demurrage-save-for-own-vehicle','Trip\DemurrageController@forOwnVehicle');
        Route::post('demurrage-save-for-out-commission-transection','Trip\DemurrageController@forOutCommissionTransection');
        Route::delete('demurrage-delete/{id}','Trip\DemurrageController@delete');

        // transection
        Route::post('transection-save-for-single-challan','Trip\TransectionController@forSingleChallan');
        Route::post('transection-save-for-up-down-challan','Trip\TransectionController@forUpDownChallan');
        Route::post('transection-save-for-out-commission-transection','Trip\TransectionController@forOutCommissionTransection');

        Route::delete('transection-delete/{transId}','Trip\TransectionController@transectionDelete');

    });

    // Route::post('trips', 'Trip\TripController@store');
    // Route::post('trips-update', 'Trip\TripController@update');

    // trip vairation store and update

    // Route::get('trip-delete/{id}','Trip\TripController@tripDelete');
    Route::delete('trip-delete-all/{id}','Trip\TripController@tripDeleteAll');

    // oil expense
    Route::post('trip-oil-expense-save','Trip\TripController@tripOilExpenseStore');
    Route::delete('trip-oil-expense-delete/{id}','Trip\TripController@tripOilExpenseDelete');

    // meter expense
    Route::post('trip-meter-save','Trip\TripController@tripMeterStore');
    Route::delete('trip-meter-delete/{id}','Trip\TripController@tripMeterDelete');

    // report
    Route::get('trip-report-form','Trip\TripController@tripReportForm');
    Route::get('trip-report','Trip\TripController@tripReport');


    // trip report section
    Route::get('own-vehicle-summary-report', 'Trip\TripReportController@ownVehicleSummaryReport');

    /* ------------------------------------------
    / Provider module
    / ------------------------------------------ */
    Route::get('providers','Provider\ProviderController@index');
    // Route::post('due-payment-to-provider','Provider\ProviderController@duePaymentToProvider');
    Route::get('provider-report','Provider\ProviderController@report');

    /* ------------------------------------------
    / Company module
    / ------------------------------------------ */
    Route::get('companies','Company\CompanyController@index');
    // Route::post('due-payment-received-from-company','Company\CompanyController@duePaymentReceivedFromCompany');

    // Route::post('company-transection','Company\CompanyController@companyTransectionStore');
    // Route::delete('company-transection','Company\CompanyController@companyTransectionDelete');

    // Route::post('challan-due-payment-to-provider','Provider\ProviderController@challanDuePaymentToProvider');
    Route::get('company-report','Company\CompanyController@report');

    /* ------------------------------------------
    / Pump module
    / ------------------------------------------ */
    Route::get('pumps','Pump\PumpController@index');
    Route::get('pump-report','Pump\PumpController@report');
    

    /* ------------------------------------------
    / Expense module
    / ------------------------------------------ */
    Route::resource('expenses','Expense\ExpenseController');
    Route::get('challan-expenses','Expense\ExpenseController@challanList');
    Route::resource('oil-expenses','Expense\OilExpenseController');
    Route::get('expense-report-form','Expense\ExpenseController@reportForm');
    Route::get('expense-report','Expense\ExpenseController@expenseReport');


    /* ------------------------------------------
    / Purchases module
    / ------------------------------------------ */
    Route::resource('purchases','Purchase\PurchaseController');


    /* ------------------------------------------
    / Tyres module
    / ------------------------------------------ */
    Route::resource('tyres','Tyre\TyreController');
    Route::post('tyre-attach','Tyre\TyreController@tyreAttach');
    Route::get('tyre-report','Tyre\TyreController@report');


    /* ------------------------------------------
    / Mobils module
    / ------------------------------------------ */
    Route::resource('mobils','Mobil\MobilController');
    Route::get('mobil-report','Mobil\MobilController@report');
    

    /* ------------------------------------------
    / payment section
    ------------------------------------------ */
    Route::resource('payments', 'Payment\PaymentController');
    Route::post('payment-collection', 'Payment\PaymentController@paymentCollection');
    // Route::get('payment-collection-histories-delete/{encrypt}','Payment\PaymentController@paymentCollectionDelete');

    Route::get('payment-report-form','Payment\PaymentController@paymentReportForm');
    Route::get('payment-report','Payment\PaymentController@paymentReport');

    /* ------------------------------------------
    / users section
    ------------------------------------------ */
    Route::resource('user/lists', 'User\UserController');
    Route::post('user/change-password/{id}', 'User\UserController@changePassword');
    Route::resource('user/roles', 'User\RoleController');


    /* ------------------------------------------
    / documents section
    ------------------------------------------ */
    Route::resource('documents', 'Document\DocumentController');
    Route::get('document-report', 'Document\DocumentController@report');
    


    /* ------------------------------------------
    / pump section
    / ------------------------------------------ */
    // report
    // Route::get('pump-report-form','Pump\PumpReportController@pump_report_form');
    // Route::get('pump-general-report','Pump\PumpReportController@pump_general_report');
    // Route::get('pump-monthly-yearly-report','Pump\PumpReportController@pump_monthly_yearly_report');


    /* ------------------------------------------
    / Report section
    ------------------------------------------ */
    Route::get('deposit-expense-form','Report\DepositExpenseReportController@deposit_expense_report_form');
    Route::get('deposit-expense-report','Report\DepositExpenseReportController@deposit_expense_report');

    Route::get('daily-accounts-report-form','Report\ReportController@dailyAccountsReportForm');
    // Route::get('daily-accounts-report','Report\ReportController@dailyAccountsReport');
    Route::get('daily-accounts-report-first-format','Report\ReportController@firstFormat');

    /* ------------------------------------------
    / Report section
    ------------------------------------------ */
    Route::resource('accounts','Account\AccountController');
    Route::resource('account-transections','Account\AccountTransectionController');
    Route::post('balance-transfer','Account\AccountTransectionController@balanceTransfer');
    Route::get('account-report','Account\AccountController@report');
    
    /*------------------------------------------------------------
    / for activites resource
    ------------------------------------------------------------ */
    Route::resource('activites','Activity\ActivityController');

    /*------------------------------------------------------------
    / vehicle module
    ------------------------------------------------------------ */
    Route::resource('vehicles', 'Vehicle\VehicleController');
    Route::post('vehicles/status', 'Vehicle\VehicleController@status');
    Route::get('vehicles/details/{id}', 'Vehicle\VehicleController@details');
    Route::get('vehicles-documents', 'Vehicle\VehicleController@documents');

    /*------------------------------------------------------------
    / staff module
    ------------------------------------------------------------ */
    Route::resource('staffs', 'Staff\StaffController');
    Route::post('staffs/status', 'Staff\StaffController@status');
    Route::get('staffs/details/{id}', 'Staff\StaffController@details');
    Route::get('staffs/print/{id}', 'Staff\StaffController@print');
    Route::post('staff-sort','Staff\StaffController@sort_update');

    // reference
    Route::get('staff/reference/{id}', 'Staff\StaffReferenceController@index');
    Route::post('staff/reference', 'Staff\StaffReferenceController@store');
    Route::put('staff/reference/{id}', 'Staff\StaffReferenceController@update');
    Route::delete('staff/reference/{id}', 'Staff\StaffReferenceController@destroy');
    Route::post('staff/make-main-referrer/{id}', 'Staff\StaffReferenceController@makeMainReferrer');
    
    /*------------------------------------------------------------
    / notifications module
    ------------------------------------------------------------ */
    Route::resource('notifications', 'Notification\NotificationController');

    /*------------------------------------------------------------
    / for setting resource
    ------------------------------------------------------------ */
    Route::resource('setting', 'Settings\SettingController@index');

    Route::prefix('settings')->group(function () {

        Route::resource('investors', 'Settings\InvestorController');
        Route::post('investor-sort', 'Settings\InvestorController@sort_update');

        Route::resource('banks', 'Settings\BankController');
        Route::post('bank-sort','Settings\BankController@sort_update');

        // Route::resource('staffs', 'Settings\StaffController');
        // Route::post('staff-sort','Settings\StaffController@sort_update');

        Route::resource('suppliers', 'Settings\SupplierController');
        // Route::post('supplier-sort', 'Settings\SupplierController@sort_update');

        Route::resource('companies', 'Settings\CompanyController');
        Route::post('company-sort','Settings\CompanyController@sort_update');

        Route::resource('areas', 'Settings\AreaController');
        // Route::post('area-sort','Settings\AreaController@sort_update');

        Route::resource('expenses', 'Settings\ExpenseController');
        Route::post('expense-sort', 'Settings\ExpenseController@sort_update');

        Route::resource('pumps', 'Settings\PumpController');
        Route::post('pump-sort','Settings\PumpController@sort_update');

        Route::resource('vehicles', 'Settings\VehicleController');
        Route::get('supplier-wise-vehicle/{supp_id}', 'Settings\VehicleController@supplier_wise_vehicle');

        Route::resource('brands', 'Settings\BrandController');
        Route::post('brand-sort', 'Settings\BrandController@sort_update');

        Route::resource('tyer-positions', 'Settings\PositionController');
        Route::post('position-sort', 'Settings\PositionController@sort_update');

        Route::resource('default', 'Settings\DefaultController');

        Route::resource('providers', 'Settings\SettingProviderController');
        Route::post('providers-update', 'Settings\SettingProviderController@update');

        Route::get('system', 'Settings\SettingController@system');
        Route::post('save-system', 'Settings\SettingController@saveSystem');

        Route::get('admin', 'Settings\SettingController@admin');
        Route::post('save-admin', 'Settings\SettingController@saveAdmin');
        
    });

    /*------------------------------------------------------------
    / for setting admin resource
    ------------------------------------------------------------ */
    Route::prefix('admin')->group(function () {
        Route::get('system', 'Admin\SettingController@system');
        Route::post('save-system', 'Admin\SettingController@saveSystem');
    });

    /*------------------------------------------------------------
    / for CRON Module
    ------------------------------------------------------------ */
    Route::prefix('cron')->group(function () {

        Route::get('checkDocumentNotification', 'Cron\NotificationController@checkDocumentNotification');

    });

});


/* ---------------------------------------
/ Artisan Command
--------------------------------------- */
Route::get('clear',function(){
    try{
        \Artisan::call('optimize:clear');
        echo 'Optimized Successfully!';
    }
    catch(\Exception $e){
        echo $e->getMessage();
    }
});

Route::get('call/{key}',function($key){
    if($key == '3135'){
    try{
            \Artisan::call('migrate');
            echo 'Migrated Successfully!';
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
    } else {
        echo 'Not matched!';
    }
});

Route::get('shutdown/{key}',function($key){
    if($key == '3135'){
        try{
            \Artisan::call('down');
            echo 'Shutdown Successfully!';
        }
        catch(\Exception $e){
            echo $e->getMessage();
        }
    } else {
        echo 'Not matched!';
    }
});

// Route::get('/seed', function () {
//     try{
//         \Artisan::call('db:seed');
//         echo 'Seeded Successfully!';
//     }
//     catch(\Exception $e){
//         echo $e->getMessage();
//     }
// });

// Route::get('queue',function(){
//     try{
//         \Artisan::call('queue:listen');
//         echo 'Queue Listen Successfully Running!';
//     }
//     catch(\Exception $e){
//         echo $e->getMessage();
//     }
// });

/*------------------------------------------------------------
/ public controller
------------------------------------------------------------ */
// Route::get('/public/{encrypt}', 'PublicController@index');
// Route::get('backup','DatabaseBackupController@db_backup');