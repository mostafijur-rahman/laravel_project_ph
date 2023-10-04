<?php

namespace App\Http\Controllers\Trip;

use App\Http\Controllers\Controller;

// request
use Illuminate\Http\Request;
use App\Http\Requests\Trip\TripRequest;
use App\Http\Requests\Trip\TripUpdateRequest;
use App\Http\Requests\Trip\TripMeterRequest;
use App\Http\Requests\Trip\TripOilExpenseRequest;
use App\Http\Requests\Trip\TripDemarageRequest;

use App\Http\Traits\AccountTransTrait;

use App\Http\Requests\Trip\OutCommissionTransectionRequest;

// model
use App\Models\Trips\Trip;
use App\Models\Trips\TripCompany;
use App\Models\Trips\TripProvider;
use App\Models\Trips\TripMeter;
use App\Models\Trips\TripOilExpense;
use App\Models\Trips\TripDemarage;
use App\Models\Trips\TripChallan;
use App\Models\Expenses\Expense;
use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingTimeSheet;
use App\Models\Settings\SettingStaff;
use App\Models\Settings\SettingArea;
use App\Models\Settings\SettingExpense;
use App\Models\Settings\SettingSupplier;
use App\Models\Settings\SettingUnit;
use App\Models\Settings\SettingCompany;
use App\Models\Settings\SettingPump;
use App\Models\Accounts\Account;
use App\Models\Accounts\AccountTransection;


// other class
use DB;
use Toastr;
use Auth;
use PDF;
use Carbon\Carbon;
use Storage;
use Illuminate\Database\Eloquent\ModelNotFoundException;

// service
use App\Services\CommonService;

class OutCommissionTransection extends Controller {

    use AccountTransTrait;

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){

        $data['request'] = $request;
    
        $data['top_title'] = __('cmn.transection_with_commission_challan') .' '. __('cmn.create');
        $data['title'] = __('cmn.transection_with_commission_challan') .' '. __('cmn.create');

        $data['menu'] = 'challan_create';
        $data['sub_menu'] = 'out_commission_transection';
        
        $data['companies'] = SettingCompany::orderBy('sort','asc')->get();
        $data['areas'] = SettingArea::orderBy('id','desc')->get();
        $data['units'] = SettingUnit::get();

        // field sugestions
        $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
        $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
        $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
        $data['unique_provider_driver_phones'] = TripProvider::latest()->get(['driver_phone'])->unique('driver_phone');
        $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
        $data['unique_provider_owner_phones'] = TripProvider::latest()->get(['owner_phone'])->unique('owner_phone');
        $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');
        $data['unique_provider_reference_phones'] = TripProvider::latest()->get(['reference_phone'])->unique('reference_phone');

        $current_user_id = Auth::user()->id;
        $data['accounts'] = Account::orderByRaw("IF(user_id = $current_user_id, 0,1)")->orderBy('sort', 'asc')->get();

        // is redirect to edit/copy page
        if($request->input('page_name') == 'edit' || $request->input('page_name') == 'copy'){
            return $this->edit($request, $data);
        }

        $data['action_url'] = 'trips/out-commission-transection';
        $data['trip'] = null;
        return view('trip.trip_routing', $data);
    }

    public function store(OutCommissionTransectionRequest $request){

        // dd($request);

        DB::beginTransaction();

        try {
            
            // trips table
            $tripModel = new Trip();
            $tripModel->type = $request->input('ownership');
            $tripModel->encrypt = uniqid();
            $tripModel->number = $request->input('number');
            $tripModel->date = $request->input('date');
            $tripModel->account_take_date = $request->input('account_take_date');
            $tripModel->serial = null;
            $tripModel->time_id = null;

            $tripModel->buyer_name = $request->input('buyer_name');
            $tripModel->buyer_code = $request->input('buyer_code');
            $tripModel->order_no =$request->input('order_no');
            $tripModel->depu_change_bill = $request->input('depu_change_bill');
            $tripModel->gate_pass_no = $request->input('gate_pass_no');
            $tripModel->lock_no = $request->input('lock_no');
            $tripModel->load_point_reach_time = $request->input('load_point_reach_time');

            $tripModel->box = $request->input('box');
            $tripModel->weight = $request->input('weight');
            $tripModel->unit_id = $request->input('unit_id');
            $tripModel->goods = $request->input('goods');
            $tripModel->note = $request->input('note');
            $tripModel->created_by = Auth::user()->id;
            $tripModel->save();

            // validation contra > advacne
            // trip company
            $comContractFair = $request->input('com_contract_fair')??0;
            $comAdvanceFair = $request->input('com_advance_fair')??0;

            $companyModel = new TripCompany();
            $companyModel->trip_id = $tripModel->id;
            $companyModel->company_id = $request->input('company_id');
            $companyModel->contract_fair = $comContractFair;
            $companyModel->advance_fair = $comAdvanceFair;
            $companyModel->received_fair = 0;
            $companyModel->due_fair = $comContractFair - $comAdvanceFair;
            $companyModel->deduction_fair = 0;
            $companyModel->extend_fair = 0;
            $companyModel->demarage = 0;
            $companyModel->demarage_received = 0;
            $companyModel->demarage_due = 0;
            $companyModel->save();

            // validation contra > advacne
            $contractFair = $request->input('contract_fair')??0;
            $advanceFair = $request->input('advance_fair')??0;

            // trip provider
            $providerModel = new TripProvider();

            $providerModel->trip_id = $tripModel->id;
            $providerModel->ownership =$request->input('ownership');

            $providerModel->vehicle_number = $request->input('vehicle_number');
            $providerModel->driver_name = $request->input('driver_name');
            $providerModel->driver_phone = $request->input('driver_phone');
            $providerModel->owner_name = $request->input('owner_name');
            $providerModel->owner_phone = $request->input('owner_phone');
            $providerModel->reference_name = $request->input('reference_name');
            $providerModel->reference_phone = $request->input('reference_phone');

            $providerModel->contract_fair = $contractFair;
            $providerModel->advance_fair = $advanceFair;
            $providerModel->received_fair = 0;
            $providerModel->due_fair = $contractFair-$advanceFair;
            $providerModel->deduction_fair = 0;
            $providerModel->extend_fair = 0;
            $providerModel->demarage = 0;
            $providerModel->demarage_received = 0;
            $providerModel->demarage_due = 0;
            $providerModel->save();

            // load point insert
            $loads = $request->input('load_id');
            $tripModel->points()->attach($loads, ['trip_id' => $tripModel->id, 'point'=>'load']);
        
            // unload point insert
            $unloads = $request->input('unload_id');
            $tripModel->points()->attach($unloads, ['trip_id' => $tripModel->id, 'point'=>'unload']);

            $trip_date = Carbon::createFromFormat('Y-m-d', $tripModel->date)->format('d/m/Y');

            // deposit transection
            if($comAdvanceFair > 0){

                // transection record
                $trans['account_id'] = $request->input('com_account_id');
                $trans['type'] = 'in';
                $trans['amount'] = $comAdvanceFair;
                $trans['date'] = $trip_date;
                $trans['transactionable_id'] = $tripModel->id;
                $trans['transactionable_type'] = 'trip';
                $trans['for'] = 'advance_has_been_received_from_the_company_for_the_trip';
                $transaction = $this->transaction($trans);

                // pivot table transection
                $tripChallanModel = new TripChallan();
                $tripChallanFillData = collect($tripChallanModel->getFillable());
                $tripChallanFinalData = $tripChallanFillData->merge([
                    'trip_id' => $tripModel->id,
                    'account_transection_id' => $transaction->id,
                    'for'=> 'company_trip',
                    'date'=> $trip_date,
                    'amount'=> $comAdvanceFair,
                ])->toArray();
                $tripChallanModel->create($tripChallanFinalData);

                $account = Account::where('id', $trans['account_id']);
                $account->increment('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);
            }

            // expense transection
            if($advanceFair > 0){
                
                if(!setting('admin_system.zero_balance_transection')){
                    if($advanceFair > Account::find($request->input('account_id'))->balance){
                        Toastr::error('',__('cmn.there_is_no_sufficient_balance_in_the_payment_account_so_the_transaction_is_not_acceptable'));
                        return redirect()->back();
                    }
                }

                $trans2['account_id'] = $request->input('account_id');
                $trans2['type'] = 'out';
                $trans2['amount'] = $advanceFair;
                $trans2['date'] = $trip_date;
                $trans2['transactionable_id'] = $tripModel->id;
                $trans2['transactionable_type'] = 'trip';
                $trans2['for'] = 'the_vehicle_provider_has_been_paid_in_advance_for_the_trip';
                $transaction2 = $this->transaction($trans2);

                // pivot table transection
                $tripChallanModel = new TripChallan();
                $tripChallanFillData = collect($tripChallanModel->getFillable());
                $tripChallanFinalData = $tripChallanFillData->merge([
                    'trip_id' => $tripModel->id,
                    'account_transection_id' => $transaction2->id,
                    'for'=> 'provider_trip',
                    'date'=> $trip_date,
                    'amount'=> $advanceFair,
                ])->toArray();
                $tripChallanModel->create($tripChallanFinalData);

                $account = Account::where('id', $trans2['account_id']);
                $account->decrement('balance', $trans2['amount'], ['updated_by'=> Auth::user()->id]);
            }

            // dd('test');

            DB::commit();

            if($advanceFair > 0 || $comAdvanceFair > 0){
                Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            }
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect('trips?page_name=details&type=out_commission_transection&trip_id='. $tripModel->id);

        }catch (\Exception $e) {

            DB::rollback();
            Storage::put('trip_create_error_report.txt', $e->getMessage());
            Storage::put('trip_create_error_file_name.txt', $e->getFile());
            Storage::put('trip_create_error_file_line.txt', $e->getLine());

            // dd($e->getMessage());
            // Toastr::error('', __('cmn.did_not_added'));
            Toastr::error('', 'Something wrong and written it on error file');
            return redirect()->back();
        }
    }

    public function edit($request, $data){

        if(!$request->input('trip_id')){
            Toastr::error(__('cmn.trip_did_not_found'));
            return redirect()->back();
        }

        if(!Trip::where('id', $request->input('trip_id'))->exists()){
            Toastr::error('',__('cmn.trip_did_not_found'));
            return redirect('trips?page_name=list');
        }

        $data['trip'] = Trip::with('vehicle','company', 'provider','points', 'transactions', 'oilExpenses', 'expenses')->where('id', $request->input('trip_id'))->first();
        
        // is edit/copy page related value
        if($request->input('page_name') == 'edit'){

            $data['top_title'] = $data['trip']->number . ' ' . __('cmn.number') .' '.__('cmn.challan').' '.__('cmn.edit').' '.__('cmn.page');
            $data['title'] = $data['trip']->number . ' ' . __('cmn.number') .' '.__('cmn.challan').' '.__('cmn.edit').' '.__('cmn.page');
            $data['action_url'] = 'trips/out-commission-transection/' . $data['trip']->id;

        } elseif($request->input('page_name') == 'copy') {

            $data['top_title'] = $data['trip']->number . ' ' . __('cmn.number') .' '.__('cmn.challan').' '.__('cmn.copy').' '.__('cmn.page');
            $data['title'] = $data['trip']->number . ' ' . __('cmn.number') .' '.__('cmn.challan').' '.__('cmn.copy').' '.__('cmn.page');
            $data['action_url'] = 'trips/out-commission-transection';

        }

        $data['sub_menu'] = 'trip_create';

        // load, unload points
        $load=[];
        $unload=[];
        if($data['trip']->points){
            foreach($data['trip']->points as $point){
                ($point->pivot->point == 'unload')?$unload[] = $point->id:$load[] = $point->id;
            }
        }
        $data['load'] = $load;
        $data['unload'] = $unload;  

        // if advacne received then get account id 
        if(AccountTransection::where('transactionable_type', 'trip')
                ->where('transactionable_id', $data['trip']->id)
                ->where('for', 'advance_has_been_received_from_the_company_for_the_trip')->exists()){

                // fetch advacne transection info
                $transection = AccountTransection::where('transactionable_type', 'trip')
                            ->where('transactionable_id', $data['trip']->id)
                            ->where('for', 'advance_has_been_received_from_the_company_for_the_trip')
                            ->select('account_id')
                            ->first();
                    
                $data['advance_received_account_id'] = $transection->account_id;

        } else {
            $data['advance_received_account_id'] = null;
        }

        return view('trip.trip_routing', $data);
    }

    public function update(Request $request){

        // dd($request);
        // $this->validate($request, [
            
        //     // trip
        //     'number' => 'required|unique:trips,number,' . $request->input('trip_id') . ',id,deleted_at,NULL',
        //     'date' => 'required',
        //     'load_id' => 'required',
        //     'unload_id' => 'required',
        //     'box' => 'nullable | integer', 
        //     'weight' => 'nullable | numeric',
        //     'unit_id' => 'nullable | integer', 
        //     'goods' => 'nullable | string', 
        //     'note' => 'nullable | string',

        //     // for provider
        //     'vehicle_number' => 'required | string',
        //     'driver_name' => 'nullable | string', 
        //     'driver_phone' => 'nullable | string', 
        //     'owner_name' => 'nullable | string', 
        //     'owner_phone' => 'nullable | string',
        //     'reference_name' => 'nullable | string', 
        //     'reference_phone' => 'nullable | string',

        //     // for company
        //     'company_id' => 'required | integer',
        // ]);

        // try {
            DB::beginTransaction();

            $trip_id = $request->input('trip_id');

            // trips
            $tripModel = Trip::find($trip_id);
            $tripModel->number = $request->input('number');
            $tripModel->date = $request->input('date');

            $tripModel->buyer_name = $request->input('buyer_name');
            $tripModel->buyer_code = $request->input('buyer_code');
            $tripModel->order_no =$request->input('order_no');
            $tripModel->depu_change_bill = $request->input('depu_change_bill');
            $tripModel->gate_pass_no = $request->input('gate_pass_no');
            $tripModel->lock_no = $request->input('lock_no');
            $tripModel->load_point_reach_time = $request->input('load_point_reach_time');

            $tripModel->box = $request->input('box');
            $tripModel->weight = $request->input('weight');
            $tripModel->unit_id = $request->input('unit_id');
            $tripModel->goods = $request->input('goods');
            $tripModel->note = $request->input('note');
            $tripModel->updated_by = Auth::user()->id;
            $tripModel->save();


            // trip provider related transection ----------------
            $trip_date = Carbon::createFromFormat('Y-m-d', $tripModel->date)->format('d/m/Y');

            $providerContractFair = $request->input('contract_fair')??0;
            $providerAdvanceFair = $request->input('advance_fair')??0;

            $providerModel = TripProvider::where('trip_id', $trip_id)->first();

            // provider contract fair validation
            if(($providerAdvanceFair + $providerModel->received_fair) > $providerContractFair){
                Toastr::error('','গাড়ী প্রদানকারীর সাথে চুক্তি ভাড়ার চেয়ে চালানের অগ্রিম ভাড়া এবং পরবর্তী প্রদান ভাড়ার পরিমান বেশি, তাই চুক্তি ভাড়ার চেয়ে অতিরিক্ত প্রদান ভাড়ার জন্য আপডেটি গ্রহণ যোগ্য হলোনা।');
                return redirect()->back();
            }

            // check is any advacne received yet or not
            if(AccountTransection::where('transactionable_type', 'trip')
                            ->where('transactionable_id', $trip_id)
                            ->where('for', 'the_vehicle_provider_has_been_paid_in_advance_for_the_trip')->exists()){

                // fetch advacne transection info
                $transectionOfProvider = AccountTransection::where('transactionable_type', 'trip')
                                ->where('transactionable_id', $trip_id)
                                ->where('for', 'the_vehicle_provider_has_been_paid_in_advance_for_the_trip')
                                ->first();

                $accountOfProvider = Account::where('id', $transectionOfProvider->account_id)->first();
                $tripChallanOfProvider = TripChallan::where('account_transection_id', $transectionOfProvider->id)->first();

                // if not name account then 
                // delete old transection and also trip challan and increment account balance
                // and insert a new out transection
                if($request->input('account_id') != $transectionOfProvider->account_id) {

                    // decrement account balance
                    $accountOfProvider->increment('balance', $transectionOfProvider->amount , ['updated_by'=> Auth::user()->id]);

                    // delete old challan
                    $tripChallanOfProvider->delete();

                    // delete old transection
                    $transectionOfProvider->delete();

                    // a new transection will insert here if advance amount more then 0 ....
                    if($providerAdvanceFair > 0){

                        $providerTrans['account_id'] = $request->input('account_id');
                        $providerTrans['type'] = 'out';
                        $providerTrans['amount'] = $providerAdvanceFair;
                        $providerTrans['date'] = $trip_date;
                        $providerTrans['transactionable_id'] = $tripModel->id;
                        $providerTrans['transactionable_type'] = 'trip';
                        $providerTrans['for'] = 'the_vehicle_provider_has_been_paid_in_advance_for_the_trip';
                        $providerTransaction = $this->transaction($providerTrans);

                        // pivot table transection
                        $tripChallanModel = new TripChallan();
                        $tripChallanFillData = collect($tripChallanModel->getFillable());
                        $tripChallanFinalData = $tripChallanFillData->merge([
                            'trip_id' => $tripModel->id,
                            'account_transection_id' => $providerTransaction->id,
                            'for'=> 'provider_trip',
                            'date'=> $trip_date,
                            'amount'=> $providerAdvanceFair,
                        ])->toArray();
                        $tripChallanModel->create($tripChallanFinalData);

                        $account = Account::where('id', $providerTrans['account_id']);
                        $account->decrement('balance', $providerTrans['amount'], ['updated_by'=> Auth::user()->id]);
                        
                        Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
                    }

                // if new advacnce fair and old advance fair is not same      
                } elseif($providerAdvanceFair != $transectionOfProvider->amount) {

                    if($providerAdvanceFair == 0) {

                        // increment account balance
                        $accountOfProvider->increment('balance', $transectionOfProvider->amount , ['updated_by'=> Auth::user()->id]);

                        // delete old challan
                        $tripChallanOfProvider->delete();

                        // delete old transection
                        $transectionOfProvider->delete();

                    } elseif($providerAdvanceFair > $transectionOfProvider->amount){

                        $added_amount = $providerAdvanceFair - $transectionOfProvider->amount;
                        $transectionOfProvider->update(['amount'=> $providerAdvanceFair, 'date'=> $trip_date, 'updated_by'=> Auth::user()->id]);

                        // added amount need to decrease from current account
                        $accountOfProvider->decrement('balance', $added_amount, ['updated_by' => Auth::user()->id]);
                        // update trip challan provider amount
                        $tripChallanOfProvider->update(['amount' => $providerAdvanceFair, 'date' => $trip_date]);

                    } elseif($providerAdvanceFair < $transectionOfProvider->amount){

                        $minus_amount = $transectionOfProvider->amount - $providerAdvanceFair;
                        $transectionOfProvider->update(['amount'=> $providerAdvanceFair, 'date'=> $trip_date, 'updated_by'=> Auth::user()->id]);

                        // minus amount need to increase from current account
                        $accountOfProvider->increment('balance', $minus_amount, ['updated_by'=> Auth::user()->id]);
                        $tripChallanOfProvider->update(['amount' => $providerAdvanceFair, 'date' => $trip_date]);
                        
                    } else {

                        $transectionOfProvider->update(['date'=> $trip_date, 'updated_by'=> Auth::user()->id]);
                        $tripChallanOfProvider->update(['date'=> $trip_date]);

                    }

                // this is other thing
                } else {

                    $transectionOfProvider->update(['date'=> $trip_date, 'updated_by'=> Auth::user()->id]);
                    $tripChallanOfProvider->update(['date'=> $trip_date]);

                }

                // if not changed anything then will not happen any transection

            // if advacne received not yet then a new treansection will insert if has any advance amount
            } else {

                // expense transection
                if($providerAdvanceFair > 0){

                    $providerTrans['account_id'] = $request->input('account_id');
                    $providerTrans['type'] = 'out';
                    $providerTrans['amount'] = $providerAdvanceFair;
                    $providerTrans['date'] = $trip_date;
                    $providerTrans['transactionable_id'] = $tripModel->id;
                    $providerTrans['transactionable_type'] = 'trip';
                    $providerTrans['for'] = 'the_vehicle_provider_has_been_paid_in_advance_for_the_trip';
                    $providerTrans = $this->transaction($providerTrans);

                    // pivot table transection
                    $tripChallanModel = new TripChallan();
                    $tripChallanFillData = collect($tripChallanModel->getFillable());
                    $tripChallanFinalData = $tripChallanFillData->merge([
                        'trip_id' => $tripModel->id,
                        'account_transection_id' => $providerTrans->id,
                        'for'=> 'provider_trip',
                        'date'=> $trip_date,
                        'amount'=> $providerAdvanceFair,
                    ])->toArray();
                    $tripChallanModel->create($tripChallanFinalData);

                    $account = Account::where('id', $providerTrans['account_id']);
                    $account->decrement('balance', $providerTrans['amount'], ['updated_by'=> Auth::user()->id]);
                    Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
                }

            }

            $providerModel->vehicle_number = $request->input('vehicle_number');
            $providerModel->driver_name = $request->input('driver_name');
            $providerModel->driver_phone = $request->input('driver_phone');
            $providerModel->owner_name = $request->input('owner_name');
            $providerModel->owner_phone = $request->input('owner_phone');
            $providerModel->reference_name = $request->input('reference_name');
            $providerModel->reference_phone = $request->input('reference_phone');

            $providerModel->contract_fair = $providerContractFair;
            $providerModel->advance_fair = $providerAdvanceFair;
            $providerModel->due_fair = $providerContractFair - ($providerModel->received_fair + $providerAdvanceFair);
            $providerModel->save();





            // trip company related transection ----------------
            $comContractFair = $request->input('com_contract_fair')??0;
            $comAdvanceFair = $request->input('com_advance_fair')??0;

            $companyModel = TripCompany::where('trip_id', $trip_id)->first();

            // company contract fair validation
            if(($comAdvanceFair + $companyModel->received_fair) > $comContractFair){

                Toastr::error('','চুক্তি ভাড়ার চেয়ে চালানের অগ্রিম ভাড়া এবং পরবর্তী জমা ভাড়ার পরিমান বেশি, তাই চুক্তি ভাড়ার চেয়ে অতিরিক্ত জমা ভাড়ার জন্য আপডেটি গ্রহণ যোগ্য হলোনা।');
                return redirect()->back();

            }

            // check is any advacne received yet or not
            if(AccountTransection::where('transactionable_type', 'trip')
                                ->where('transactionable_id', $trip_id)
                                ->where('for', 'advance_has_been_received_from_the_company_for_the_trip')->exists()){
                
                // fetch advacne transection info
                $transection = AccountTransection::where('transactionable_type', 'trip')
                                ->where('transactionable_id', $trip_id)
                                ->where('for', 'advance_has_been_received_from_the_company_for_the_trip')
                                ->first();

                $account = Account::where('id', $transection->account_id)->first();
                $tripChallan = TripChallan::where('account_transection_id', $transection->id)->first();
            
                // if not name account
                if($request->input('com_account_id') != $transection->account_id) {

                    // decrement account balance
                    $account->decrement('balance', $transection->amount , ['updated_by'=> Auth::user()->id]);

                    // delete old challan
                    $tripChallan->delete();

                    // delete old transection
                    $transection->delete();

                    // a new transection will insert here if advance amount more then 0 ....
                    if($comAdvanceFair > 0){

                        $trans['account_id'] = $request->input('com_account_id');
                        $trans['type'] = 'in';
                        $trans['amount'] = $comAdvanceFair;
                        $trans['date'] = $trip_date;
                        $trans['transactionable_id'] = $tripModel->id;
                        $trans['transactionable_type'] = 'trip';
                        $trans['for'] = 'advance_has_been_received_from_the_company_for_the_trip';
                        $transaction = $this->transaction($trans);

                        // pivot table transection
                        $tripChallanModel = new TripChallan();
                        $tripChallanFillData = collect($tripChallanModel->getFillable());
                        $tripChallanFinalData = $tripChallanFillData->merge([
                            'trip_id' => $tripModel->id,
                            'account_transection_id' => $transaction->id,
                            'for'=> 'company_trip',
                            'date'=> $trip_date,
                            'amount'=> $comAdvanceFair,
                        ])->toArray();
                        $tripChallanModel->create($tripChallanFinalData);

                        $account = Account::where('id', $trans['account_id']);
                        $account->increment('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);
                        
                        Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
                    }

                // if new advacnce fair and old advance fair is not same      
                } elseif($comAdvanceFair != $transection->amount) {

                    if($comAdvanceFair == 0) {

                        // decrement account balance
                        $account->decrement('balance', $transection->amount , ['updated_by'=> Auth::user()->id]);

                        // delete old challan
                        $tripChallan->delete();

                        // delete old transection
                        $transection->delete();

                    } elseif($comAdvanceFair > $transection->amount){

                        $added_amount = $comAdvanceFair - $transection->amount;
                        $transection->update(['amount'=> $comAdvanceFair, 'date'=> $trip_date, 'updated_by'=> Auth::user()->id]);
    
                        // added amount need to decrease from current account
                        $account->increment('balance', $added_amount, ['updated_by' => Auth::user()->id]);
                        $tripChallan->update(['amount' => $comAdvanceFair, 'date' => $trip_date]);

                    } elseif($comAdvanceFair < $transection->amount){

                        $minus_amount = $transection->amount - $comAdvanceFair;
                        $transection->update(['amount'=> $comAdvanceFair, 'date'=> $trip_date, 'updated_by'=> Auth::user()->id]);
    
                        // minus amount need to increase from current account
                        $account->decrement('balance', $minus_amount, ['updated_by'=> Auth::user()->id]);
                        $tripChallan->update(['amount' => $comAdvanceFair, 'date' => $trip_date]);
                        
                    } else {

                        $transection->update(['date'=> $trip_date, 'updated_by'=> Auth::user()->id]);
                        $tripChallan->update(['date'=> $trip_date]);

                    }

                } else {

                    $transection->update(['date'=> $trip_date, 'updated_by'=> Auth::user()->id]);
                    $tripChallan->update(['date'=> $trip_date]);

                }

                // if not changed anything then will not happen any transection

            // if advacne received not yet then a new treansection will insert if has any advance amount
            } else {

                // deposit transection
                if($comAdvanceFair > 0){

                    $trans['account_id'] = $request->input('com_account_id');
                    $trans['type'] = 'in';
                    $trans['amount'] = $comAdvanceFair;
                    $trans['date'] = $trip_date;
                    $trans['transactionable_id'] = $tripModel->id;
                    $trans['transactionable_type'] = 'trip';
                    $trans['for'] = 'advance_has_been_received_from_the_company_for_the_trip';
                    $transaction = $this->transaction($trans);

                    // pivot table transection
                    $tripChallanModel = new TripChallan();
                    $tripChallanFillData = collect($tripChallanModel->getFillable());
                    $tripChallanFinalData = $tripChallanFillData->merge([
                        'trip_id' => $tripModel->id,
                        'account_transection_id' => $transaction->id,
                        'for'=> 'company_trip',
                        'date'=> $trip_date,
                        'amount'=> $comAdvanceFair,
                    ])->toArray();
                    $tripChallanModel->create($tripChallanFinalData);

                    $account = Account::where('id', $trans['account_id']);
                    $account->increment('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);
                    
                    Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
                }

            }
                    
            // other company
            $companyModel->company_id = $request->input('company_id');
            $companyModel->contract_fair = $comContractFair;
            $companyModel->advance_fair = $comAdvanceFair;
            $companyModel->due_fair = $comContractFair - ($companyModel->received_fair + $comAdvanceFair);
            $companyModel->save();

            // load point insert
            $tripModel->points()->detach();
            $loads = $request->input('load_id');
            $tripModel->points()->attach($loads, ['trip_id' => $trip_id, 'point'=>'load']);

            // unload point insert
            $unloads = $request->input('unload_id');
            $tripModel->points()->attach($unloads, ['trip_id' => $trip_id, 'point'=>'unload']);
            DB::commit();

            Toastr::success('',__('cmn.successfully_updated'));
            return redirect('trips?page_name=details&type=out_commission_transection&trip_id='. $trip_id);


        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Storage::put('trip_create_error_report.txt', $e->getMessage());
        //     Storage::put('trip_create_error_file_name.txt', $e->getFile());
        //     Storage::put('trip_create_error_file_line.txt', $e->getLine());

        //     // dd($e->getMessage());
        //     // Toastr::error('', __('cmn.did_not_added'));
        //     Toastr::error('', 'Something wrong and written it on error file');
        //     return redirect()->back();
        // }
    }
}