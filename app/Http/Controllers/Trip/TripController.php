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
use App\Models\Loans\Loan;
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

        if(!$request->input('page_name')){
            Toastr::error(__('cmn.undefined_page_name'));
            return redirect()->back();
        }

        // common method a dhube
        switch ($request->input('page_name')) {
            case 'list':
                return $this->list($request);
                break;

            case 'print':
                return $this->print($request);
                break;

            case 'edit':
                return $this->edit($request);
                break;
            
            case 'copy':
                return $this->copy($request);
                break;

            case 'details':
                return $this->details($request);
                break;

            case 'transection':
                return $this->transection($request);
                break;

            case 'general_expense':
                return $this->general_expense($request);
                break;

            case 'oil_expense':
                return $this->oil_expense($request);
                break;

            case 'meter':
                return $this->meter($request);
                break;

            case 'demarage':
                return $this->demarage($request);
                break;

            default:
                Toastr::error('',__('cmn.page_not_found'));
                return redirect()->back();
        }

    }

    public function list($request){

        $data['request'] = $request;
        $data['menu'] = 'challan_list';

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

        switch ($request->input('type')) {

            case 'own_vehicle_single':
                $title = __('cmn.own_vehicle_single_challan') .' '. __('cmn.list');
                $data['sub_menu'] = 'own_vehicle_single';
                break;

            case 'own_vehicle_up_down':
                $title = __('cmn.own_vehicle_up_down_challan') .' '. __('cmn.list');
                $data['sub_menu'] = 'own_vehicle_up_down';
                break;
            
            case 'own_vehicle_up_down_new':
                $title = __('cmn.own_vehicle_up_down_challan') .' '. __('cmn.list');
                $data['sub_menu'] = 'own_vehicle_up_down_new';
                break;

            case 'out_commission_transection':
                $title = __('cmn.rental_vehicle_transection_with_commission_challan') .' '. __('cmn.list');
                $data['sub_menu'] = 'out_commission_transection';
                break;

            case 'out_commission':
                $title = __('cmn.rental_vehicle_only_commission_challan') .' '. __('cmn.list');
                $data['sub_menu'] = 'out_commission';
                break;
        }

        $data['top_title'] = $title;
        $data['title'] = $title;

        if($request->input('type') == 'own_vehicle_up_down' || $request->input('type') == 'own_vehicle_up_down_new'){ 
            return $this->group_wise_list($request, $data);
        } else {
            return $this->non_group_list($request, $data);
        }
    }

    protected function non_group_list($request, $data){

        $time_start = microtime(true);

        // DB::connection()->enableQueryLog();
        $query = Trip::query()->with('vehicle', 'oilExpenses.pump', 'meter', 'demarage','provider','company', 'challanHistoryReceived');

        if($request->input('type')){ 
            $query = $query->where('type', $request->input('type'));
        } else {
            Toastr::error(__('cmn.undefined_trip_type'));
            return redirect()->back();
        }

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

        $time_gone = microtime(true) - $time_start;
        $data['execution_time'] = number_format((float)(($time_gone*1000)/1000), 4, '.', '');

        return view('trip.trip_list', $data);
    }

    protected function group_wise_list($request, $data){

        $time_start = microtime(true);

        $query = Trip::query()->with('vehicle', 'oilExpenses.pump', 'meter', 'demarage','provider','company', 'challanHistoryReceived');
        
        // group id must be exists
        $query = $query->whereNotNull('group_id');

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

        // group by action
        $query = $query->groupBy('group_id');
        
        if($request->input('order_by')){ 
            if($request->input('order_by') == 'asc'){
                $query = $query->orderBy('id','ASC');
            }
            if($request->input('order_by') == 'desc'){
                $query = $query->orderBy('id','DESC');
            }
        }

        if($request->input('per_page')){ 
            $query = $query->paginate($request->input('per_page'));
        } else {
            $query = $query->paginate(50);
            $request['per_page'] = 50;
        }

        $query = tap($query)->map(function($value){

            // get trip ids of this group
            $trip_ids = Trip::where('group_id', $value->group_id)->select('id')->get()->toArray();

            if(count($trip_ids) > 0){

                if(isset($trip_ids[1]['id'])){
                    $value['down_trip'] = Trip::query()->with('vehicle', 'oilExpenses.pump', 'meter', 'demarage','provider','company', 'challanHistoryReceived')->where('id', $trip_ids[1]['id'])->first();
                } else {
                    $value['down_trip'] = null;
                }

            } else {
                $value['down_trip'] = null;
            }

            return $value;
        });

        $time_gone = microtime(true) - $time_start;
        $data['execution_time'] = number_format((float)(($time_gone*1000)/1000), 4, '.', '');

        $data['trips'] = $query;

        return view('trip.trip_list', $data);
    }

    public function print($request){
        
        $this->tripTypeTripIdGroupIdCheck($request);
        return $this->tripReport($request);

    }

    // public function edit($request){

    //     if(!$request->input('type')){
    //         Toastr::error(__('cmn.select_the_car_rental_medium_first'));
    //         return redirect()->back();
    //     }

    //     if(!$request->input('trip_id')){
    //         Toastr::error(__('cmn.trip_did_not_found'));
    //         return redirect()->back();
    //     }

    //     if(!Trip::where('id', $request->input('trip_id'))->exists()){
    //         Toastr::error('',__('cmn.trip_did_not_found'));
    //         return redirect('trips?page_name=list');
    //     }

    //     $title = __('cmn.trip_edit');
    //     $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');

    //     switch ($request->input('type')) {
    //         case 'out_from_market':
    //             // common suggestion
    //             $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
    //             $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
    //             $data['unique_provider_driver_phones'] = TripProvider::latest()->get(['driver_phone'])->unique('driver_phone');
    //             $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
    //             $data['unique_provider_owner_phones'] = TripProvider::latest()->get(['owner_phone'])->unique('owner_phone');
    //             $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');
    //             $data['unique_provider_reference_phones'] = TripProvider::latest()->get(['reference_phone'])->unique('reference_phone');
    //             $data['action_url'] = 'trips/out-from-market';
    //             break;

    //         case 'out_nagad_commission':
    //             // common suggestion
    //             $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
    //             $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
    //             $data['unique_provider_driver_phones'] = TripProvider::latest()->get(['driver_phone'])->unique('driver_phone');
    //             $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
    //             $data['unique_provider_owner_phones'] = TripProvider::latest()->get(['owner_phone'])->unique('owner_phone');
    //             $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');
    //             $data['unique_provider_reference_phones'] = TripProvider::latest()->get(['reference_phone'])->unique('reference_phone');
    //             $data['action_url'] = 'trips/out-nagad-commission';
    //             break;


    //         case 'own_vehicle_single':
    //             $data['staffs'] = SettingStaff::orderBy('sort', 'asc')->get();
    //             $data['action_url'] = 'trips/own-vehicle';
    //             break;

    //         case 'own_vehicle_up_down':
    //             $data['staffs'] = SettingStaff::orderBy('sort', 'asc')->get();
    //             $data['action_url'] = 'trips/own-vehicle';
    //             break;

    //         default:
    //             Toastr::error(__('cmn.select_the_car_rental_medium_first'));
    //             return redirect()->back();
    //             break;
    //     }

    //     return $this->common($request, $title, $data);
    // }

    public function copy($request){

        if(!$request->input('type')){
            Toastr::error(__('cmn.select_the_car_rental_medium_first'));
            return redirect()->back();
        }

        if(!$request->input('trip_id')){
            Toastr::error(__('cmn.trip_did_not_found'));
            return redirect()->back();
        }

        if(!Trip::where('id', $request->input('trip_id'))->exists()){
            Toastr::error('',__('cmn.trip_did_not_found'));
            return redirect('trips?page_name=list');
        }

        $title = __('cmn.trip_copy');
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

        return $this->common($request, $title, $data);
    }

    public function details($request){

        $this->tripTypeTripIdGroupIdCheck($request);

        $title = __('cmn.details');
        $data['action_url'] = 'trips';
        return $this->common($request, $title);
    }

    public function transection($request){

        $this->tripTypeTripIdGroupIdCheck($request);

        $title = __('cmn.transection');
        $data['action_url'] = 'trips';
        $data['unique_recipients_names'] = TripChallan::latest()->get(['recipients_name'])->unique('recipients_name');
        $data['unique_recipients_phones'] = TripChallan::latest()->get(['recipients_phone'])->unique('recipients_phone');

        return $this->common($request, $title, $data);
    }

    public function general_expense($request){

        $this->tripTypeTripIdGroupIdCheck($request);

        $title = __('cmn.general_expense');
        $data['action_url'] = 'trips';
        return $this->common($request, $title, $data);
    }

    public function oil_expense($request){

        $this->tripTypeTripIdGroupIdCheck($request);

        $title = __('cmn.oil_expense');
        $data['action_url'] = 'trips';
        return $this->common($request, $title, $data);

    }

    public function meter($request){

        $this->tripTypeTripIdGroupIdCheck($request);

        $title = __('cmn.meter_info');
        $data['action_url'] = 'trips';
        return $this->common($request, $title, $data);

    }

    public function demarage($request){

        $this->tripTypeTripIdGroupIdCheck($request);

        $title = __('cmn.demurrage');
        $data['action_url'] = 'trips';
        return $this->common($request, $title, $data);

    }

    public function common($request, $title, $data = null){

        $data['request'] = $request;
        $data['menu'] = 'trip';

        $data['top_title'] = $title;
        $data['title'] =  $title;
        $data['sub_menu'] = 'trip_list';
        $data['vehicles'] = SettingVehicle::all();
        $data['companies'] = SettingCompany::orderBy('sort','asc')->get();
        // $data['time_sheets'] = SettingTimeSheet::all();
        $data['areas'] = SettingArea::orderBy('id','desc')->get();
        $data['units'] = SettingUnit::get();
        
        $data['expenses'] = SettingExpense::orderBy('sort', 'asc')->get();
        $data['pumps'] = SettingPump::orderBy('sort', 'asc')->get();

        switch ($request->input('type')) {

            case 'own_vehicle_single':
            case 'out_commission_transection':
            case 'out_commission':

                if(!Trip::where('id', $request->input('trip_id'))->exists()){
                    Toastr::error('',__('cmn.trip_did_not_found'));
                    return redirect('trips?page_name=list&type=own_vehicle_single&per_page=50&order_by=desc');
                }
    
                $data['trip'] = Trip::with('vehicle','company', 'provider','points', 'transactions', 'oilExpenses', 'expenses')->where('id', $request->input('trip_id'))->first();
            
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

                break;

            case 'own_vehicle_up_down':
            case 'own_vehicle_up_down_new':
                

                if(!Trip::where('group_id', $request->input('group_id'))->exists()){
                    Toastr::error('',__('cmn.trip_did_not_found'));
                    return redirect('trips?page_name=list&type=own_vehicle_up_down&per_page=50&order_by=desc');
                }
    
                // first trip id always consider
                $trip_ids = Trip::where('group_id', $request->input('group_id'))->select('id')->get()->toArray();
    
                if(count($trip_ids) > 0){
                    // first trip id
                    $data['trip'] = Trip::with('vehicle','company', 'provider','points', 'transactions')->where('id', $trip_ids[0])->first();
                    
                    // up and down trip
                    $data['up_trip'] = Trip::with('vehicle','company', 'provider','points', 'transactions', 'demarage')->where('id', $trip_ids[0]['id'])->first();
    
                    if(isset($trip_ids[1]['id'])){
                        $data['down_trip'] = Trip::with('vehicle','company', 'provider','points', 'transactions', 'demarage')->where('id', $trip_ids[1]['id'])->first();
                    } else {
                        $data['down_trip'] = null;
                    }
                    
                } else {
                    Toastr::error('',__('cmn.up_down_challan_trip_not_found'));
                    return redirect()->back();
                }

                break;
            
            default:
                Toastr::error('',__('cmn.undefined_trip_type_from_common'));
                return redirect()->back();
                break;
        }

        
        // common transection accounts ids
        // here first trip_id == $data['trip'] consider for group or non group wise 
        if(isset($data['trip']) && count($data['trip']->transactions) > 0){
            $account_id = $data['trip']->transactions[0]->account_id;
            $data['accounts'] = Account::orderByRaw("IF(id = $account_id, 0,1)")->orderBy('sort', 'asc')->get();
        } else {
            $current_user_id = Auth::user()->id;
            $data['accounts'] = Account::orderByRaw("IF(user_id = $current_user_id, 0,1)")->orderBy('sort', 'asc')->get();
        }

        return view('trip.trip_routing', $data);
    }

    public function tripDeleteAll($id){
        if (!Trip::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }

        $isGroupExist = Trip::where('id', $id)->whereNotNull('group_id')->exists();
        if($isGroupExist){

            $trip_info = Trip::where('id', $id)->select('group_id')->first();

            // assign multi trip
            $trip_ids = Trip::where('group_id', $trip_info->group_id)->select('id')->get()->toArray();

        } else {

            // assign single trip
            $trip_ids[] = ['id' => $id];
        }

        DB::beginTransaction();
        try {

            foreach($trip_ids as $id){

                $this->tripRelatedDataDelete($id['id']);

                $tripDemarage = TripDemarage::where('trip_id', $id['id'])->first();
                if($tripDemarage){
                    $tripDemarage->update(['updated_by'=> Auth::user()->id]);
                    $tripDemarage->delete();
                }

                TripChallan::where('trip_id', $id['id'])->delete();
                TripCompany::where('trip_id', $id['id'])->delete();
                TripProvider::where('trip_id', $id['id'])->delete();

                $trip = Trip::find($id['id']);
                $transections = $trip->transactions()->get();

                if(count($transections) > 0){
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
                }

                $trip->update(['updated_by'=> Auth::user()->id]);
                $trip->delete();

            }

            DB::commit();
            Toastr::success('',__('cmn.successfully_deleted'));
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            // return redirect('trips?page_name=list');
            return redirect()->back();
        }catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            // dd($e->getFile());
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }



    // need to cut from here and add a new class start --------------------
    public function tripOilExpenseStore(TripOilExpenseRequest $request){
        // old format = 2023-01-17
        // now time = 17/01/2023
        try {

            DB::beginTransaction();
            $oilExpenseModel = new TripOilExpense();

            $oilExpenseModel->encrypt = uniqid();
            $oilExpenseModel->vehicle_id = $request->input('vehicle_id');
            $oilExpenseModel->trip_id = $request->input('trip_id');
            $oilExpenseModel->pump_id = $request->input('pump_id');
            $oilExpenseModel->voucher_id = $request->input('voucher_id');
            $oilExpenseModel->liter = $request->input('liter');
            $oilExpenseModel->rate = $request->input('rate');

            $oilExpenseModel->bill = $request->input('liter')*$request->input('rate');
            // $oilExpenseModel->date = Carbon::createFromFormat('d/m/Y', $request->input('trip_date'))->format('Y-m-d');
            $oilExpenseModel->date = $request->input('trip_date');
            $oilExpenseModel->note = $request->input('note');
            $oilExpenseModel->created_by = Auth::user()->id;
            $oilExpenseModel->save();

            if($request->input('account_id') != 'loan'){

                if($request->input('liter')*$request->input('rate') > Account::find($request->input('account_id'))->balance){
                    Toastr::error('',__('cmn.there_is_no_sufficient_balance_in_the_payment_account_so_the_transaction_is_not_acceptable'));
                    return redirect()->back();
                }

                // transection
                $trans['account_id'] = $request->input('account_id');
                $trans['type'] = 'out';
                $trans['amount'] = $request->input('liter')*$request->input('rate');
                // $trans['date'] = Carbon::createFromFormat('Y-m-d', $request->input('trip_date'))->format('d/m/Y');
                $trans['date'] = $request->input('trip_date');
                $trans['transactionable_id'] = $oilExpenseModel->id;
                $trans['transactionable_type'] = 'trip_oil_expense';
                $trans['for'] = 'oil_expense_for_the_trip';
                $this->transaction($trans);
                // account
                $account = Account::where('id', $trans['account_id']);
                $account->decrement('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);
                Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));

            } else {

                if(!$request->input('pump_id')){
                    Toastr::error('',__('cmn.pump_must_be_selected'));
                    return redirect()->back();
                }

                // loan insertion
                $loan = new Loan();
                $loan->encrypt = uniqid();

                $loan->vendor_id = $request->input('pump_id');
                $loan->vendor_table = 'setting_pumps';

                $loan->reason_id = $oilExpenseModel->id;
                $loan->reason_table = 'trip_oil_expenses';

                $loan->date = Carbon::createFromFormat('d/m/Y', $request->input('trip_date'))->format('Y-m-d');
                $loan->amount = $request->input('liter')*$request->input('rate');

                $loan->created_by = Auth::user()->id;
                $loan->save();
            }
            DB::commit();

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
        // if (!TripOilExpense::where('id', $id)->exists()) {
        //     Toastr::error('',__('cmn.did_not_find'));
        //     return redirect()->back();
        // }
        // try {
            DB::beginTransaction();
            $tripOilExpense = TripOilExpense::find($id);

            // account increment
            $transection = $tripOilExpense->transaction()->first();
            if($transection){
                $account = Account::whereId($transection->account_id);
                $account->increment('balance', $tripOilExpense->bill, ['updated_by'=> Auth::user()->id]);
                Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            }

            // loan
            $loan = Loan::where('reason_table', 'trip_oil_expenses')->where('reason_id', $tripOilExpense->id)->first();
            if($loan){
                $loan->delete();
            }

            // expense
            $tripOilExpense->update(['updated_by'=> Auth::user()->id]);
            $tripOilExpense->transaction()->delete();
            $tripOilExpense->delete();

            DB::commit();
            Toastr::success('',__('cmn.successfully_deleted'));

            return redirect()->back();
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     Toastr::error('',__('cmn.did_not_deleted'));
        //     return redirect()->back();
        // }
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
    // need to cut from here and add a new class end --------------------




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
        $data['title'] =  __('cmn.trip') .' '. __('cmn.report');

        $data['menu'] = 'challan_report';
        $data['sub_menu'] = 'challan';

        $data['request'] = $request;
        $data['vehicles'] = SettingVehicle::all();
        $data['staffs'] = SettingStaff::where('designation_id', 1)->get();
        $data['companies'] = SettingCompany::orderBy('sort', 'asc')->get();
        
        $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
        $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
        
        $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
        $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
        $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');

        return view('trip.report_form.common', $data);
    }

    public function tripReport(Request $request){

        // dd($request);
        // "page_name" => "print"
        // "type" => "own_vehicle_single"
        // "trip_id" => "2

        ini_set('max_execution_time', '600'); // 10 minutes
        ini_set("pcre.backtrack_limit", "5000000");

        $title = '';
        switch ($request->input('date_range_status')) {
            case 'all_time':
                $title = __('cmn.all_time');
                break;

            case 'monthly_report':
                $title = __('cmn.monthly_report');
                break;

            case 'yearly_report':
                $title = __('cmn.yearly_report');
                break;

            case 'date_wise':
                $title = __('cmn.date_wise');
                break;

            default:
                $title = __('cmn.undefined');
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
            
            $title = $data['trip']->number .' ' . __('cmn.challan_print_copy');
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

            $pdf = PDF::loadView('trip.report_page.challan_single_view.common', $data);

            if($request->input('download_pdf') == 'true'){
                return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            } else {
                return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            }
        }

        // for up down trip report
        if($request->has('group_id')){

            if(!Trip::where('group_id', $request->input('group_id'))->exists()){
                Toastr::error('',__('cmn.did_not_found'));
                return redirect()->back();
            }

            // other pdf --------- 
            $trip_ids = Trip::where('group_id', $request->input('group_id'))->select('id')->get()->toArray();
            
            if(count($trip_ids) > 0){

                // first trip id
                $data['trip'] = Trip::with('vehicle','company', 'provider','points', 'transactions')
                                ->where('id', $trip_ids[0]['id'])->first();

                $title = $trip_ids[0]['id'] .' ' . __('cmn.challan_print_copy');
                $data['top_title'] = $title;
                $data['title'] = $title;
                
                // up and down trip
                $data['up_trip'] = Trip::with('vehicle','company','provider','points','transactions','demarage')->where('id', $trip_ids[0]['id'])->first();

                if(isset($trip_ids[1]['id'])){
                    $data['down_trip'] = Trip::with('vehicle','company','provider','points','transactions','demarage')->where('id', $trip_ids[1]['id'])->first();
                } else {
                    $data['down_trip'] = null;
                }

                $pdf = PDF::loadView('trip.report_page.challan_single_view.common', $data);
                if($request->input('download_pdf') == 'true'){
                    return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
                } else {
                    return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
                }

            } else {
                Toastr::error('',__('cmn.up_down_challan_trip_not_found'));
                return redirect()->back();
            }

        }

        // DB::connection()->enableQueryLog();
        $query = Trip::query()->with('vehicle', 'oilExpenses.pump', 'meter', 'demarage','provider','company','challanHistoryReceived');

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
            $pdf = PDF::loadView('trip.report.trip_multi_pdf.common', $data);
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

        if($request->input('report_name') == 'challan_received_history'){
            $pdf = PDF::loadView('trip.report.challan_received_history_pdf', $data);
            if($request->input('download_pdf') == 'true'){
                return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            } else {
                return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            }
        }

    }

    public function tripTypeTripIdGroupIdCheck($request){
        if(!$request->input('type')){
            Toastr::error(__('cmn.select_the_car_rental_medium_first'));
            return redirect()->back();
        }

        if($request->has('trip_id')){

            if(!Trip::where('id', $request->input('trip_id'))->exists()){
                Toastr::error('',__('cmn.trip_did_not_found'));
                return redirect()->back();
            }
        }
        
        elseif($request->has('group_id')) {

            if(!Trip::where('group_id', $request->input('group_id'))->exists()){
                Toastr::error('',__('cmn.group_wise_trip_did_not_found'));
                return redirect()->back();
            }
        }

        else {
            Toastr::error('',__('cmn.please_provide_trip_id_or_group_id'));
            return redirect()->back();
        }
    }

}