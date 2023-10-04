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

class TripController extends Controller {

    use AccountTransTrait;

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $data['request'] = $request;
        $data['menu'] = 'trip';

        if($request->input('page_name') == 'list'){
            $data['top_title'] = __('cmn.trip_list');
            $data['title'] =  __('cmn.trip_list');
            $data['sub_menu'] = 'trip_list';
            $data['vehicles'] = SettingVehicle::all();
            $data['staffs'] = SettingStaff::where('designation_id', 1)->get();
            $data['companies'] = SettingCompany::orderBy('sort', 'asc')->get();

            $current_user_id = Auth::user()->id;
            $data['accounts'] = Account::orderByRaw("IF(user_id = $current_user_id, 0,1)")->orderBy('sort', 'asc')->get();

            $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
            $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
            
            $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
            $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
            $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');

            // DB::connection()->enableQueryLog();
            $query = Trip::query()->with('vehicle', 'oilExpenses.pump', 'meter', 'demarage','provider','company');
            // date range wise
            if ($request->input('date_range_status') && $request->input('date_range_status') != 'all_time') {
                $date_range_status = $request->input('date_range_status');
                $daterange = $request->input('daterange');
                $month = $request->input('month');
                $year = $request->input('year');
                // date wise
                if($date_range_status == 'date_wise' && $daterange){
                    $date = explode(' - ', $daterange);
                    $start_date = Carbon::parse($date[0])->startOfDay();
                    $end_date = Carbon::parse($date[1])->endOfDay();
                    $query = $query->whereBetween('date', [$start_date, $end_date]);
                }
                // monthly report
                if($date_range_status == 'monthly_report'){
                    if(!$month){
                        Toastr::error('',__('cmn.please_select_month_first'));
                        return redirect()->back();
                    }
                    if(!$year){
                        Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                        return redirect()->back();
                    }
                    $query = $query->whereMonth('date',$month)->whereYear('date',$year);
                }
                // yearly report
                if($date_range_status == 'yearly_report'){
                    if(!$year){
                        Toastr::error('',__('cmn.please_select_year_first'));
                        return redirect()->back();
                    }
                    $query = $query->whereYear('date',$year);
                }
            }

            if($request->input('company_id')){
                $query->whereHas('company', function($subQuery) use($request) {
                    $subQuery->where('company_id', $request->input('company_id'));
                });
            }

            if($request->input('vehicle_number')){
                $query->whereHas('provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_number', 'like', '%' . $request->input('vehicle_number') . '%');
                });
            }

            if($request->input('provider_driver')){
                $query->whereHas('provider', function($subQuery) use($request) {
                    $subQuery->where('driver_name', 'like', '%' . $request->input('provider_driver') . '%');
                });
            }

            if($request->input('provider_owner')){
                $query->whereHas('provider', function($subQuery) use($request) {
                    $subQuery->where('owner_name', 'like', '%' . $request->input('provider_owner') . '%');
                });
            }

            if($request->input('provider_reference')){
                $query->whereHas('provider', function($subQuery) use($request) {
                    $subQuery->where('reference_name', 'like', '%' . $request->input('provider_reference') . '%');
                });
            }

            if($request->input('vehicle_id')){
                $query->whereHas('provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_id', $request->input('vehicle_id'));
               });
            }

            if($request->input('trip_number')){
                $query = $query->where('number', 'like', '%' . $request->input('trip_number') . '%');
            }
            
            if($request->input('order_by')){ 
                if($request->input('order_by') == 'asc'){
                    $query = $query->orderBy('id','ASC');
                }
                if($request->input('order_by') == 'desc'){
                    $query = $query->orderBy('id','DESC');
                }
            }

            if($request->input('per_page')){ 
                $data['trips'] = $query->paginate($request->input('per_page'));
            } else {
                $data['trips'] = $query->paginate(50);
                $request['per_page']=50;
            }

            return view('trip.trip_list', $data);
        }

        elseif(
            (
            $request->input('page_name') == 'edit' || 
            $request->input('page_name') == 'copy' ||
            $request->input('page_name') == 'details' ||
            $request->input('page_name') == 'transection' ||
            $request->input('page_name') == 'general_expense' ||
            $request->input('page_name') == 'oil_expense' ||
            $request->input('page_name') == 'meter' ||
            $request->input('page_name') == 'demarage'
        ) && $request->input('trip_id')) {

            if(!$request->input('type')){
                Toastr::error(__('cmn.select_the_car_rental_medium_first'));
                return redirect()->back();
            }

            if(!Trip::where('id', $request->input('trip_id'))->exists()){
                Toastr::error('',__('cmn.trip_did_not_found'));
                return redirect('trips?page_name=list');
            }

            // $data['step'] = ($request->input('step'))?$request->input('step'):'trip';

            if($request->input('page_name') == 'edit'){

                $title = __('cmn.trip_edit');
                $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');

                switch ($request->input('type')) {
                    case 'out_from_market':
                        // common suggestion
                        $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
                        $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
                        $data['unique_provider_driver_phones'] = TripProvider::latest()->get(['driver_phone'])->unique('driver_phone');
                        $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
                        $data['unique_provider_owner_phones'] = TripProvider::latest()->get(['owner_phone'])->unique('owner_phone');
                        $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');
                        $data['unique_provider_reference_phones'] = TripProvider::latest()->get(['reference_phone'])->unique('reference_phone');
                        $data['action_url'] = 'trips/out-from-market';

                        break;
                    case 'out_nagad_commission':
                        // common suggestion
                        $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
                        $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
                        $data['unique_provider_driver_phones'] = TripProvider::latest()->get(['driver_phone'])->unique('driver_phone');
                        $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
                        $data['unique_provider_owner_phones'] = TripProvider::latest()->get(['owner_phone'])->unique('owner_phone');
                        $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');
                        $data['unique_provider_reference_phones'] = TripProvider::latest()->get(['reference_phone'])->unique('reference_phone');
                        $data['action_url'] = 'trips/out-nagad-commission';

                        break;
                    case 'own_vehicle':
                        $data['action_url'] = 'trips/own-vehicle';
                        break;
                    default:
                        Toastr::error(__('cmn.select_the_car_rental_medium_first'));
                        return redirect()->back();
                        break;
                }

            }

            if($request->input('page_name') == 'copy'){
                $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
                $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
                
                $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
                $data['unique_provider_driver_phones'] = TripProvider::latest()->get(['driver_phone'])->unique('driver_phone');
                
                $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
                $data['unique_provider_owner_phones'] = TripProvider::latest()->get(['owner_phone'])->unique('owner_phone');
                
                $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');
                $data['unique_provider_reference_phones'] = TripProvider::latest()->get(['reference_phone'])->unique('reference_phone');
                
                $title = __('cmn.trip_copy');
                $data['action_url'] = 'trips';
            }

            if($request->input('page_name') == 'details'){
                $title = __('cmn.details');
                $data['action_url'] = 'trips';
            }
            if($request->input('page_name') == 'transection'){
                $title = __('cmn.transection');
                $data['action_url'] = 'trips';

                $data['unique_recipients_names'] = TripChallan::latest()->get(['recipients_name'])->unique('recipients_name');
                $data['unique_recipients_phones'] = TripChallan::latest()->get(['recipients_phone'])->unique('recipients_phone');
            }
            if($request->input('page_name') == 'general_expense'){
                $title = __('cmn.general_expense');
                $data['action_url'] = 'trips';
            }
            if($request->input('page_name') == 'oil_expense'){
                $title = __('cmn.oil_expense');
                $data['action_url'] = 'trips';
            }
            if($request->input('page_name') == 'meter'){
                $title = __('cmn.meter_info');
                $data['action_url'] = 'trips';
            }
            if($request->input('page_name') == 'demarage'){
                $title = __('cmn.demarage');
                $data['action_url'] = 'trips';
            }

            $data['top_title'] = $title;
            $data['title'] =  $title;
            $data['sub_menu'] = 'trip_list';
            $data['vehicles'] = SettingVehicle::all();
            $data['companies'] = SettingCompany::orderBy('sort','asc')->get();
            $data['time_sheets'] = SettingTimeSheet::all();
            $data['areas'] = SettingArea::orderBy('id','desc')->get();
            $data['units'] = SettingUnit::get();
            $data['expenses'] = SettingExpense::orderBy('sort', 'asc')->get();
            $data['pumps'] = SettingPump::orderBy('sort', 'asc')->get();
            $data['trip'] = Trip::with('vehicle','company', 'provider','points', 'transactions')->where('id', $request->input('trip_id'))->first();

            if(count($data['trip']->transactions)>0){
                $account_id = $data['trip']->transactions[0]->account_id;
                $data['accounts'] = Account::orderByRaw("IF(id = $account_id, 0,1)")->orderBy('sort', 'asc')->get();
            } else {
                $current_user_id = Auth::user()->id;
                $data['accounts'] = Account::orderByRaw("IF(user_id = $current_user_id, 0,1)")->orderBy('sort', 'asc')->get();
            }
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
            // group
            $trip_info = Trip::select('group_id')->latest()->first();
            if($request->input('page') == 'copy'){
                $data['group_id'] = ($trip_info && $trip_info->group_id)?$trip_info->group_id+1:1;
            }
            return view('trip.trip_create', $data);
        }
        elseif($request->input('page_name') == 'demarages'){
            $data['top_title'] = __('cmn.demarage_list');
            $data['title'] = __('cmn.trip_demarage');
            $data['menu'] = 'trip_demarage';
            $data['sub_menu'] = 'demarages';

            $query = Trip::query()->with('vehicle','getTripsByGroupId');
            $query = $query->whereHas('demarage', function($subQuery) {
                $subQuery->where('company_amount','>',0);
                $subQuery->OrWhere('provider_amount','>',0);
            });
            if($request->input('number')){
                $query->where('number', $request->input('number'));
            }
            if($request->input('vehicle_number')){
                $query->whereHas('provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_number', $request->input('vehicle_number'));
                });
            }
            $data['trips'] = $query->orderBy('date','desc')->paginate(50);
            return view('trip.demarage_list', $data);
        }
        
        else{
            Toastr::error('',__('cmn.page_not_found'));
            return redirect('trips?page_name=list');
        }
    }





















    

    public function tripDeleteAll($id){
        if (!Trip::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }
        DB::beginTransaction();
        try {
            $this->tripRelatedDataDelete($id);

            $tripDemarage = TripDemarage::where('trip_id', $id)->first();
            if($tripDemarage){
                $tripDemarage->update(['updated_by'=> Auth::user()->id]);
                $tripDemarage->delete();
            }

            TripChallan::where('trip_id', $id)->delete();
            TripCompany::where('trip_id', $id)->delete();
            TripProvider::where('trip_id', $id)->delete();

            $trip = Trip::find($id);
            $transections = $trip->transactions()->get();
            foreach($transections as $transection){
                $account = Account::whereId($transection->account_id)->first();
                if($transection->type == 'in'){
                    $account->decrement('balance', $transection->amount, ['updated_by'=> Auth::user()->id]);
                } else {
                    $account->increment('balance', $transection->amount, ['updated_by'=> Auth::user()->id]);
                }
                $transection->update(['updated_by'=> Auth::user()->id]);
                $transection->delete();
            }
            $trip->update(['updated_by'=> Auth::user()->id]);
            $trip->delete();
            DB::commit();
            Toastr::success('',__('cmn.successfully_deleted'));
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            // return redirect('trips?page_name=list');
            return redirect()->back();
        }catch (\Exception $e) {
            DB::rollback();
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }

    public function tripOilExpenseStore(TripOilExpenseRequest $request){

        try {
            DB::beginTransaction();
            $oilExpenseModel = new TripOilExpense();

            $oilExpenseModel->encrypt = uniqid();
            $oilExpenseModel->vehicle_id = $request->input('vehicle_id');
            $oilExpenseModel->trip_id = $request->input('trip_id');
            $oilExpenseModel->pump_id = $request->input('pump_id');
            $oilExpenseModel->liter = $request->input('liter');
            $oilExpenseModel->rate = $request->input('rate');

            $oilExpenseModel->bill = $request->input('liter')*$request->input('rate');
            $oilExpenseModel->date = $request->input('trip_date');
            $oilExpenseModel->note = $request->input('note');
            $oilExpenseModel->created_by = Auth::user()->id;
            $oilExpenseModel->save();

            if($request->input('liter')*$request->input('rate') > Account::find($request->input('account_id'))->balance){
                Toastr::error('',__('cmn.there_is_no_sufficient_balance_in_the_payment_account_so_the_transaction_is_not_acceptable'));
                return redirect()->back();
            }

            // transection
            $trans['account_id'] = $request->input('account_id');
            $trans['type'] = 'out';
            $trans['amount'] = $request->input('liter')*$request->input('rate');
            $trans['date'] = Carbon::createFromFormat('Y-m-d', $request->input('trip_date'))->format('d/m/Y');
            $trans['transactionable_id'] = $oilExpenseModel->id;
            $trans['transactionable_type'] = 'trip_oil_expense';
            $trans['for'] = 'oil_expense_for_the_trip';
            $this->transaction($trans);
            // account
            $account = Account::where('id', $trans['account_id']);
            $account->decrement('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);

            DB::commit();
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back();
        }catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            Toastr::error('',__('cmn.did_not_posted'));
            return redirect()->back();
        }
    }

    public function tripOilExpenseDelete($id){
        if (!TripOilExpense::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $tripOilExpense = TripOilExpense::find($id);

            // account increment
            $transection = $tripOilExpense->transaction()->first();

            $account = Account::whereId($transection->account_id);
            $account->increment('balance', $tripOilExpense->bill, ['updated_by'=> Auth::user()->id]);
            // expense
            $tripOilExpense->update(['updated_by'=> Auth::user()->id]);
            $tripOilExpense->transaction()->delete();
            $tripOilExpense->delete();
            DB::commit();
            Toastr::success('',__('cmn.successfully_deleted'));
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }

    public function tripMeterStore(TripMeterRequest $request){
        if($request->input('previous_reading') > $request->input('current_reading')){
            Toastr::error('',__('cmn.start_meter_reading_is_more_than_the_last_meter_reading'));
            return redirect()->back();
        }
        try {
            $tripMeter = new TripMeter();
            $fillableData = collect($request->only($tripMeter->getFillable()));
            $finalData = $fillableData->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id]);   
            $tripMeter->create($finalData->toArray());
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error('',$e->message());
            return redirect()->back();
        }
    }

    public function tripMeterDelete($id){
        if (!TripMeter::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }
        try {
            TripMeter::where('id', $id)->delete();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        }catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }

    public function tripDemarageStore(TripDemarageRequest $request){
        DB::beginTransaction();
        try {

            $trip_id = $request->input('trip_id');
            $dates = $request->input('date');
            $company_amounts = $request->input('company_amount');
            $provider_amounts = $request->input('provider_amount');
            $notes = $request->input('note');
            
            $company_amount_sum = 0;
            $provider_amount_sum = 0;

            foreach($dates as $key => $date){

                $company_amount_sum += $company_amounts[$key];
                $provider_amount_sum += $provider_amounts[$key];

                $tripDemarage = new TripDemarage();
                $tripDemarage->trip_id = $trip_id;
                $tripDemarage->date = $date;
                $tripDemarage->company_amount = $company_amounts[$key];
                $tripDemarage->provider_amount = $provider_amounts[$key];
                $tripDemarage->note = $notes[$key];
                $tripDemarage->created_by = Auth::user()->id;
                $tripDemarage->save();
            }

            // save to company
            $tripCompany = TripCompany::where('trip_id', $trip_id)->first();
            $tripCompany->demarage += $company_amount_sum;
            $tripCompany->demarage_due += $company_amount_sum;
            $tripCompany->save();

            // save to provider
            $tripProvider = TripProvider::where('trip_id', $trip_id)->first();
            $tripProvider->demarage += $provider_amount_sum;
            $tripProvider->demarage_due += $provider_amount_sum;
            $tripProvider->save();   

            DB::commit();
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back(); 
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('',$e->getMessage());
            return redirect()->back();
        }
    }

    public function tripDemarageDelete($id){
        if (!TripDemarage::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $trip_demarage =  TripDemarage::where('id', $id)->first();

            // update to company
            $tripCompany = TripCompany::where('trip_id', $trip_demarage->trip_id)->first();

            if($tripCompany->demarage_due < $trip_demarage->company_amount){
                Toastr::error('', 'কোম্পানি থেকে আগে থেকেই এই পরিমান টাকা ডেমারেজ বিল গ্রহণ করা হয়েছে, তাই ডিলিট হচ্ছে না।');
                return redirect()->back();
            }
            
            $tripCompany->demarage -= $trip_demarage->company_amount;
            $tripCompany->demarage_due -= $trip_demarage->company_amount;
            $tripCompany->save();

            // update to provider
            $tripProvider = TripProvider::where('trip_id', $trip_demarage->trip_id)->first();

            if($tripProvider->demarage_due < $trip_demarage->provider_amount){
                Toastr::error('', 'প্রদানকারীকে আগে থেকেই এই পরিমান টাকা ডেমারেজ বিল দেয়া হয়েছে, তাই ডিলিট হচ্ছে না।');
                return redirect()->back();
            }

            $tripProvider->demarage -= $trip_demarage->provider_amount;
            $tripProvider->demarage_due -= $trip_demarage->provider_amount;
            $tripProvider->save();

            $trip_demarage->delete();

            DB::commit();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        }catch (\Exception $e) {
            DB::rollback();
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }

    public function tripRelatedDataDelete($trip_id){
        // expense delete
        $expenses = Expense::where('trip_id', $trip_id)->get();
        if(count($expenses)>0){
            foreach($expenses as $expense){
                // account increment
                $transection = $expense->transaction()->first();
                $account = Account::whereId($transection->account_id)->first();
                $account->increment('balance', $expense->amount, ['updated_by'=> Auth::user()->id]);
                // expense delete
                $expense->update(['updated_by'=> Auth::user()->id]);
                $expense->transaction()->delete();
                $expense->delete();
            }
        }
        // oil expense delete
        $oilExpenses = TripOilExpense::where('trip_id', $trip_id)->get();
        if(count($oilExpenses)>0){
            foreach($oilExpenses as $oilExpense){
                // account increment
                $transection = $oilExpense->transaction()->first();
                $account = Account::whereId($transection->account_id)->first();
                $account->increment('balance', $oilExpense->bill, ['updated_by'=> Auth::user()->id]);
                // oil expense delete
                $oilExpense->update(['updated_by'=> Auth::user()->id]);
                $oilExpense->transaction()->delete();
                $oilExpense->delete();
            }
        }
        // trip meter
        $tripMeter = TripMeter::where('trip_id', $trip_id)->first();
        if($tripMeter){
            $tripMeter->update(['updated_by'=> Auth::user()->id]);
            $tripMeter->delete();
        }

    }

    public function tripReportForm(Request $request){
        $data['title'] =  'ট্রিপ সংক্রান্ত রিপোর্ট';
        $data['menu'] = 'trip';
        $data['sub_menu'] = 'trip_report';
        $data['request'] = $request;
        $data['vehicles'] = SettingVehicle::all();
        $data['staffs'] = SettingStaff::where('designation_id', 1)->get();
        $data['companies'] = SettingCompany::orderBy('sort', 'asc')->get();
        
        $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
        $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
        
        $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
        $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
        $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');

        return view('trip.report_form', $data);
    }

    public function tripReport(Request $request){

        // dd($request);
        
        ini_set('max_execution_time', '600'); // 10 minutes
        ini_set("pcre.backtrack_limit", "5000000");

        $title = '';
        $date_range_status = $request->input('date_range_status');
        if($date_range_status == 'all_time'){
            $title = __('cmn.all_time');
        }
        elseif($date_range_status == 'monthly_report'){
            $title = __('cmn.monthly_report');
        }
        elseif($date_range_status == 'yearly_report'){
            $title = __('cmn.yearly_report');
        } 
        elseif($date_range_status == 'date_wise'){
            $title = __('cmn.date_wise');
        }else {
            $date_range_status = 'undefined type';
        }

        $data['request'] = $request;
        $data['title'] = $title;
        $data['menu'] = 'trip_report_form';
        $data['sub_menu'] = '';
        $data['reporting_time'] = date('d M, Y h:i:s a');

        // for single trip print
        if($request->has('trip_id')){

            if(!Trip::where('id', $request->input('trip_id'))->exists()){
                Toastr::error('',__('cmn.did_not_found'));
                return redirect('trips?page_name=list');
            }

            $data['trip'] = Trip::with('vehicle','company', 'provider','points')->where('id', $request->input('trip_id'))->first();
            
            $title = $data['trip']->number .' নং চালান এর প্রিন্ট কপি';
            $data['top_title'] = $title;
            $data['title'] = $title;


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

            $pdf = PDF::loadView('trip.report.trip_single_pdf', $data);
            if($request->input('download_pdf') == 'true'){
                return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            } else {
                return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            }
        }

        // DB::connection()->enableQueryLog();
        $query = Trip::query()->with('vehicle', 'oilExpenses.pump', 'meter', 'demarage','provider','company');

        // if($request->input('paid_status') == 'due_challan'){
        //     $query =  $query->whereHas('provider', function($subQuery) {
        //         $subQuery->where('due_fair','>',0);
        //     });
        // }

        // if($request->input('paid_status') == 'paid_challan'){
        //     $query =  $query->whereHas('provider', function($subQuery) {
        //         $subQuery->where('due_fair',0);
        //     });
        // }

        // date range wise
        if ($request->input('date_range_status') && $request->input('date_range_status') != 'all_time') {
            $date_range_status = $request->input('date_range_status');
            $daterange = $request->input('daterange');
            $month = $request->input('month');
            $year = $request->input('year');
            // date wise
            if($date_range_status == 'date_wise' && $daterange){
                $date = explode(' - ', $daterange);
                $start_date = Carbon::parse($date[0])->startOfDay();
                $end_date = Carbon::parse($date[1])->endOfDay();
                $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';

                $query = $query->whereBetween('date', [$start_date, $end_date]);
            }
            // monthly report
            if($date_range_status == 'monthly_report'){
                if(!$month){
                    Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
                    return redirect()->back();
                }
                if(!$year){
                    Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                    return redirect()->back();
                }
                $month_name = CommonService::getMonthNameByMonthId($month);
                $data['title'] .= ' - (' . __('cmn.month') .'- ' .$month_name. ', ' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
                $query = $query->whereMonth('date',$month)->whereYear('date',$year);
            }
            // yearly report
            if($date_range_status == 'yearly_report'){
                if(!$year){
                    Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                    return redirect()->back();
                }
                $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
                $query = $query->whereYear('date',$year);
            }
        }

        if($request->input('company_id')){
            $query->whereHas('company', function($subQuery) use($request) {
                    $subQuery->where('company_id',$request->input('company_id'));
            });
            $company = SettingCompany::where('id', $request->input('company_id'))->select('name')->first();
            $data['title'] .= ' - (' . __('cmn.company_name') .'- ' .$company->name. ')';
        }

        if($request->input('vehicle_number')){
            $query->whereHas('provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_number', 'like', '%' . $request->input('vehicle_number') . '%');
            });
            $data['title'] .= ' - (' . __('cmn.vehicle_number') .'- ' .$request->input('vehicle_number'). ')';
        }

        if($request->input('provider_driver')){
            $query->whereHas('provider', function($subQuery) use($request) {
                $subQuery->where('driver_name', 'like', '%' . $request->input('provider_driver') . '%');
            });
            $data['title'] .= ' - (' . __('cmn.driver') .'- ' .$request->input('provider_driver'). ')';
        }

        if($request->input('provider_owner')){
            $query->whereHas('provider', function($subQuery) use($request) {
                $subQuery->where('owner_name', 'like', '%' . $request->input('provider_owner') . '%');
            });
            $data['title'] .= ' - (' . __('cmn.owner') .'- ' .$request->input('provider_owner'). ')';
        }

        if($request->input('provider_reference')){
            $query->whereHas('provider', function($subQuery) use($request) {
                $subQuery->where('reference_name', 'like', '%' . $request->input('provider_reference') . '%');
            });
            $data['title'] .= ' - (' . __('cmn.reference') .'- ' .$request->input('provider_reference'). ')';
        }

        if($request->input('vehicle_id')){
            $query->whereHas('provider', function($subQuery) use($request) {
                $subQuery->where('vehicle_id', $request->input('vehicle_id'));
            });
            $vehicle = SettingVehicle::where('id', $request->input('vehicle_id'))->select('vehicle_number')->first();
            $data['title'] .= ' - (' . __('cmn.vehicle_number') .'- ' .$vehicle->vehicle_number. ')';
        }

        if($request->input('trip_number')){
            $query = $query->where('number', 'like', '%' . $request->input('trip_number') . '%');
            $data['title'] .= ' - (' . __('cmn.trip_number') .'- ' .$request->input('trip_number'). ')';
        }

        if($request->input('order_by')){ 
            if($request->input('order_by') == 'asc'){
                $query = $query->orderBy('id','ASC');
            }
            if($request->input('order_by') == 'desc'){
                $query = $query->orderBy('id','DESC');
            }
        }
        
        $data['trips'] = $query->get();

        $data['top_title'] = $data['title'];

        if($request->input('report_name') == 'challan'){
            $pdf = PDF::loadView('trip.report.trip_multi_pdf', $data);
            if($request->input('download_pdf') == 'true'){
                return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            } else {
                return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            }
        }

        if($request->input('report_name') == 'all_info_in_single_row'){
            $pdf = PDF::loadView('trip.report.all_info_in_single_row_pdf', $data);
            if($request->input('download_pdf') == 'true'){
                return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            } else {
                return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            }
        }
        
    }



}