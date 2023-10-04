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

use App\Http\Requests\Trip\OwnVehicleSingleRequest;

// use App\Http\Traits\TransectionTrait;
use App\Http\Traits\AccountTransTrait;

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

// use App\Models\Companies\CompanyTransection;

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

class OwnVehicleSingle extends Controller {

    use AccountTransTrait;

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $data['request'] = $request;
         
        $data['top_title'] = __('cmn.single_challan') .' '. __('cmn.create');
        $data['title'] = __('cmn.single_challan') .' '. __('cmn.create');

        $data['menu'] = 'challan_create';
        $data['sub_menu'] = 'own_vehicle_single';

        $data['vehicles'] = SettingVehicle::orderBy('sort','asc')->get();
        $data['companies'] = SettingCompany::orderBy('sort','asc')->get();
        $data['areas'] = SettingArea::orderBy('id','desc')->get();
        $data['units'] = SettingUnit::get();
        $data['staffs'] = SettingStaff::orderBy('sort', 'asc')->get();

        // field sugestions
        $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
        $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');


        // $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
        // $data['unique_provider_driver_phones'] = TripProvider::latest()->get(['driver_phone'])->unique('driver_phone');
        // $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
        // $data['unique_provider_owner_phones'] = TripProvider::latest()->get(['owner_phone'])->unique('owner_phone');
        // $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');
        // $data['unique_provider_reference_phones'] = TripProvider::latest()->get(['reference_phone'])->unique('reference_phone');

        $current_user_id = Auth::user()->id;
        $data['accounts'] = Account::orderByRaw("IF(user_id = $current_user_id, 0,1)")->orderBy('sort', 'asc')->get();

        // is redirect to edit/copy page
        if($request->input('page_name') == 'edit' || $request->input('page_name') == 'copy'){
            return $this->edit($request, $data);
        }

        $data['action_url'] = 'trips/own-vehicle-single';
        $data['trip'] = null;
        return view('trip.trip_routing', $data);
    }

    public function store(OwnVehicleSingleRequest $request){

        try {
            DB::beginTransaction();

            // trips table
            $tripModel = new Trip();
            $tripModel->type = $request->input('ownership'); // 'own_vehicle_single';
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
            $companyModel->due_fair = $comContractFair-$comAdvanceFair;
            $companyModel->deduction_fair = 0;
            $companyModel->extend_fair = 0;
            $companyModel->demarage = 0;
            $companyModel->demarage_received = 0;
            $companyModel->demarage_due = 0;
            $companyModel->save();

            // validation contra > advacne
            // trip provider
            $providerModel = new TripProvider();
            // $advanceFair = $request->input('advance_fair')??0;

            $providerModel->trip_id = $tripModel->id;
            $providerModel->ownership = $request->input('ownership');
            $providerModel->vehicle_id = $request->input('vehicle_id');
            $providerModel->driver_id = $request->input('driver_id');
            $providerModel->helper_id = $request->input('helper_id');

            $providerModel->vehicle_number = null;
            $providerModel->driver_name = null;
            $providerModel->driver_phone = null;
            $providerModel->owner_name = null;
            $providerModel->owner_phone = null;
            $providerModel->reference_name = null;
            $providerModel->reference_phone = null;

            $providerModel->contract_fair = 0;
            $providerModel->advance_fair = 0;
            $providerModel->received_fair = 0;
            $providerModel->due_fair = 0;
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

            DB::commit();
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect('trips?page_name=details&type=own_vehicle_single&trip_id='. $tripModel->id);
        }catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            // Toastr::error('', __('cmn.did_not_added'));
            // Toastr::error('', $e->getMessage());
            // return redirect()->back();
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
            $data['action_url'] = 'trips/own-vehicle-single/' . $data['trip']->id;

        } elseif($request->input('page_name') == 'copy') {

            $data['top_title'] = $data['trip']->number . ' ' . __('cmn.number') .' '.__('cmn.challan').' '.__('cmn.copy').' '.__('cmn.page');
            $data['title'] = $data['trip']->number . ' ' . __('cmn.number') .' '.__('cmn.challan').' '.__('cmn.copy').' '.__('cmn.page');
            $data['action_url'] = 'trips/own-vehicle-single/';

        }

        $data['menu'] = 'challan_list';
        $data['sub_menu'] = 'own_vehicle_single';

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

    public function update(OwnVehicleSingleRequest $request){

        // dd($request);
        try {
            DB::beginTransaction();

            $trip_id = $request->input('trip_id');

            // trips
            $tripModel = Trip::with('transactions')->find($trip_id);
            $tripModel->number = $request->input('number'); // update unique validation
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

            // trip provider
            $providerModel = TripProvider::where('trip_id', $trip_id)->first();
            $providerModel->vehicle_id = $request->input('vehicle_id');
            $providerModel->driver_id = $request->input('driver_id');
            $providerModel->helper_id = $request->input('helper_id');
            $providerModel->save();

            // load point insert
            $tripModel->points()->detach();
            $loads = $request->input('load_id');
            $tripModel->points()->attach($loads, ['trip_id' => $trip_id, 'point'=>'load']);

            // unload point insert
            $unloads = $request->input('unload_id');
            $tripModel->points()->attach($unloads, ['trip_id' => $trip_id, 'point'=>'unload']);


            // trip company
            $comContractFair = $request->input('com_contract_fair')??0;
            $comAdvanceFair = $request->input('com_advance_fair')??0;

            $companyModel = TripCompany::where('trip_id', $trip_id)->first();
            
            // contract fair validation
            if(($comAdvanceFair + $companyModel->received_fair) > $comContractFair){

                Toastr::error('','চুক্তি ভাড়ার চেয়ে চালানের অগ্রিম ভাড়া এবং পরবর্তী জমা ভাড়ার পরিমান বেশি, তাই চুক্তি ভাড়ার চেয়ে অতিরিক্ত জমা ভাড়ার জন্য আপডেটি গ্রহণ যোগ্য হলোনা।');
                return redirect()->back();

            }

            $trip_date = Carbon::createFromFormat('Y-m-d', $tripModel->date)->format('d/m/Y');

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

            DB::commit();
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect('trips?page_name=details&type=own_vehicle_single&trip_id='. $trip_id);

        } catch (\Exception $e) {

            DB::rollback();
            // Storage::put('trip_create_error_report.txt', $e->getMessage());
            // Storage::put('trip_create_error_file_name.txt', $e->getFile());
            // Storage::put('trip_create_error_file_line.txt', $e->getLine());

            dd('Message = ' . $e->getMessage() . ' Line = ' . $e->getLine());
            
            // Toastr::error('', __('cmn.did_not_added'));
            Toastr::error('', 'Something wrong and written it on error file');
            return redirect()->back();

        }
    }

    public function getDriverAndHelperId($vehicleId){

        if(!SettingVehicle::where('id', $vehicleId)->exists()){
            Toastr::error('vehicle not found!', 'Sorry');
            return redirect()->back();
        }
        try {
            $query = SettingVehicle::where('id', $vehicleId)->select('driver_id', 'helper_id')->first();
            return response()->json($query);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], 404);
        } 

    }

    public function uniqueChallanValidation($challanNumber){

        if(!Trip::where('number', $challanNumber)->exists()){
            return response()->json(['message' => __('cmn.you_can_use_it'), 'status' => true]);
        } else {
            return response()->json(['message' => __('cmn.challan_number_already_exists'), 'status' => false]);
        }
    }

    
}