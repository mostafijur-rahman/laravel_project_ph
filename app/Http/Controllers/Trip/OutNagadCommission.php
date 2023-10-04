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


class OutNagadCommission extends Controller {

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
        $data['request'] = $request;
        $data['menu'] = 'trip'; 
    
        $data['top_title'] = __('cmn.challan_create');
        $data['title'] = __('cmn.challan_create');
        $data['sub_menu'] = 'trip_create';
        
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

        $data['action_url'] = 'trips/out-nagad-commission';
        $data['trip'] = null;
        return view('trip.trip_create', $data);
    }

    public function store(Request $request){

        $this->validate($request, [

            // general 
            'number' => "required | unique:trips,number,NULL,id,deleted_at,NULL", // string
            'account_take_date' => 'required', // date
            'date' => 'required', // date
            'load_id' => 'required',
            'unload_id' => 'required',
            'box' => 'nullable | integer', 
            'weight' => 'nullable | numeric',
            'unit_id' => 'nullable | integer', 
            'goods' => 'nullable |  max:250', // string 
            'note' => 'nullable', // string 

            // for provider
            'ownership' => 'required | string',
            'vehicle_number' => 'required | string', // | max:50 - when we add this validation then 'required' validateion did not worked
            'driver_name' => 'nullable | max:250', // string
            'driver_phone' => 'nullable | max:250', // string
            'owner_name' => 'nullable | max:250', // string
            'owner_phone' => 'nullable | max:250', // string
            'reference_name' => 'nullable | max:250', // string
            'reference_phone' => 'nullable | max:250', // string
            'contract_fair' => 'required | min:-1 | integer',

            // for company
            'company_id' => 'required | integer',
            'com_contract_fair' => 'required | min:-1 | integer',

        ]);

        try {
            DB::beginTransaction();
            // trips table
            $tripModel = new Trip();
            $tripModel->type = $request->input('ownership');
            $tripModel->encrypt = uniqid();
            $tripModel->number = $request->input('number');
            $tripModel->date = $request->input('date');
            $tripModel->account_take_date = $request->input('account_take_date');
            $tripModel->serial = null;
            $tripModel->time_id = null;
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

            // trip company
            $companyModel = new TripCompany();
            $companyModel->trip_id = $tripModel->id;
            $companyModel->company_id = $request->input('company_id');
            $companyModel->contract_fair = $comContractFair;
            $companyModel->advance_fair = 0;
            $companyModel->received_fair = 0;
            $companyModel->due_fair = 0;
            $companyModel->deduction_fair = 0;
            $companyModel->extend_fair = 0;
            $companyModel->demarage = 0;
            $companyModel->demarage_received = 0;
            $companyModel->demarage_due = 0;
            $companyModel->save();

            // trip provider
            $providerModel = new TripProvider();

            $providerModel->trip_id = $tripModel->id;
            $providerModel->ownership = $request->input('ownership');
            $providerModel->vehicle_number = $request->input('vehicle_number');

            $providerModel->driver_name = $request->input('driver_name');
            $providerModel->driver_phone = $request->input('driver_phone');
            $providerModel->owner_name = $request->input('owner_name');
            $providerModel->owner_phone = $request->input('owner_phone');
            $providerModel->reference_name = $request->input('reference_name');
            $providerModel->reference_phone = $request->input('reference_phone');

            $providerModel->contract_fair = $request->input('contract_fair')??0;
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

            DB::commit();
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect('trips?page_name=details&type=out_nagad_commission&trip_id='. $tripModel->id);

        } catch (\Exception $e) {

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
    

    public function update(Request $request){

        // dd($request);

        // "trip_id" => "4"
        // "_method" => "put"
        // "number" => "3"
        // "date" => "18/06/2022"
        // "load_id" => array:1 [▶]
        // "unload_id" => array:1 [▶]
        // "box" => "1"
        // "weight" => "2.00"
        // "unit_id" => "2"
        // "goods" => "3"
        // "note" => "4"
        // "ownership" => "out_nagad_commission"

        // "vehicle_number" => "77"
        // "driver_name" => "11"
        // "driver_phone" => "22"
        // "owner_name" => "33"
        // "owner_phone" => "44"
        // "reference_name" => "55"
        // "reference_phone" => "66"
        // "contract_fair" => "12000"
        // "company_id" => "1"
        // "com_contract_fair" => "15000"
        
        $this->validate($request, [
            
            // trip
            'number' => 'required|unique:trips,number,' . $request->input('trip_id') . ',id,deleted_at,NULL',
            'date' => 'required',
            'load_id' => 'required',
            'unload_id' => 'required',
            'box' => 'nullable | integer', 
            'weight' => 'nullable | numeric',
            'unit_id' => 'nullable | integer', 
            'goods' => 'nullable | string', 
            'note' => 'nullable | string',
    
            // for provider
            'vehicle_number' => 'required | string',
            'driver_name' => 'nullable | string', 
            'driver_phone' => 'nullable | string', 
            'owner_name' => 'nullable | string', 
            'owner_phone' => 'nullable | string',
            'reference_name' => 'nullable | string', 
            'reference_phone' => 'nullable | string',
    
            // for company
            'company_id' => 'required | integer',
            'com_contract_fair' => 'required | min:-1 | integer',
        ]);

        try {
            DB::beginTransaction();

            $trip_id = $request->input('trip_id');
            // trips
            $tripModel = Trip::find($trip_id);
            $tripModel->number = $request->input('number');
            $tripModel->date = $request->input('date');
            $tripModel->box = $request->input('box');
            $tripModel->weight = $request->input('weight');
            $tripModel->unit_id = $request->input('unit_id');
            $tripModel->goods = $request->input('goods');
            $tripModel->note = $request->input('note');
            $tripModel->updated_by = Auth::user()->id;
            $tripModel->save();

            // trip company
            $companyModel = TripCompany::where('trip_id', $trip_id)->first();
            $companyModel->company_id = $request->input('company_id');
            $companyModel->contract_fair = $request->input('com_contract_fair');
            $companyModel->save();

            // trip provider
            $providerModel = TripProvider::where('trip_id', $trip_id)->first();
            $providerModel->vehicle_id = $request->input('vehicle_id');
            $providerModel->vehicle_number = $request->input('vehicle_number');
            $providerModel->driver_name = $request->input('driver_name');
            $providerModel->driver_phone = $request->input('driver_phone');
            $providerModel->owner_name = $request->input('owner_name');
            $providerModel->owner_phone = $request->input('owner_phone');
            $providerModel->reference_name = $request->input('reference_name');
            $providerModel->reference_phone = $request->input('reference_phone');
            $providerModel->contract_fair = $request->input('contract_fair')??0;
            $providerModel->save();
        
            // load point insert
            $tripModel->points()->detach();
            $loads = $request->input('load_id');
            $tripModel->points()->attach($loads, ['trip_id' => $trip_id, 'point'=>'load']);

            // unload point insert
            $unloads = $request->input('unload_id');
            $tripModel->points()->attach($unloads, ['trip_id' => $trip_id, 'point'=>'unload']);
            DB::commit();

            Toastr::success('',__('cmn.successfully_updated'));
            return redirect('trips?page_name=details&type=out_nagad_commission&trip_id='. $trip_id);

        } catch (\Exception $e) {
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





}