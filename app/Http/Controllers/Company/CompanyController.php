<?php

namespace App\Http\Controllers\Company;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\AccountTransTrait;

use App\Models\Trips\Trip;
use App\Models\Trips\TripCompany;
use App\Models\Trips\TripChallan;
use App\Models\Trips\TripProvider;
use App\Models\Accounts\Account;
use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingCompany;
use App\Models\Shares\Share;
// use App\Models\Companies\CompanyTransection;

use App\Services\CommonService;
use App\Http\Requests\Trip\TripTransectionRequest;

use DB;
use Auth;
use Toastr;
use Carbon\Carbon;
use PDF;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CompanyController extends Controller{

    use AccountTransTrait;

    public function __construct(){
        $this->middleware('auth');
    }

    function index(Request $request){
        $data['request'] = $request;
        $data['menu'] = 'company';
        $data['vehicles'] = SettingVehicle::all();
        $data['companies'] = SettingCompany::orderBy('sort', 'asc')->get();

        $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
        $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');

        $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
        $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
        $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');
        $data['unique_voucher_ids'] = TripChallan::latest()->get(['voucher_id'])->unique('voucher_id');

        if($request->input('page_name') == 'company_list'){
            $data['top_title'] = __('cmn.company_list');
            $data['title'] =  __('cmn.company_list');
            $data['sub_menu'] = 'company_list';
            $data['request'] = $request;
            $query = SettingCompany::query();
            if($request->name_phone){
                $query = $query->where('name', 'like', '%' . $request->name_phone . '%')
                            ->orWhere('phone', 'like', '%' . $request->name_phone . '%');
            }
            $data['lists'] = $query->orderBy('sort', 'asc')->paginate(100);
            return view('company.company_list', $data);
        }

        // if($request->input('page_name') == 'company_transection'){
        //     $data['top_title'] = __('cmn.transection');
        //     $data['title'] =  __('cmn.transection');
        //     $data['sub_menu'] = 'company_list';
        //     $data['request'] = $request;
        //     $data['company'] = SettingCompany::find($request->input('company_id'));
        //     $data['lists'] = CompanyTransection::where('company_id', $request->input('company_id'))
        //                                         ->orderBy('id', 'desc')
        //                                         ->paginate(100);
        //     return view('company.company_transection', $data);
        // }

        if($request->input('page_name') == 'challan_due'){
            $data['top_title'] = __('cmn.challan_due');
            $data['title'] =  __('cmn.challan_due');
            $data['sub_menu'] = 'challan_due';
            $data['accounts'] = Account::orderBy('sort', 'asc')->get();


            $query = Trip::query()->with('vehicle','getTripsByGroupId')->whereHas('company', function($subQuery) {
                $subQuery->where('due_fair','>',0);
            });
            if($request->input('number')){
                $query->where('number', $request->input('number'));
            }
            if($request->input('vehicle_number')){
                $query->whereHas('provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_number', $request->input('vehicle_number'));
                });
            }



            $data['trips'] = $query->orderBy('date','desc')->paginate(1000);
            $data['form_url'] = 'due-payment-received-from-company';
            $data['payment_type'] = 'challan_due';
            return view('company.due_list', $data);
        }
        if($request->input('page_name') == 'challan_paid'){

            $data['top_title'] = __('cmn.challan_paid');
            $data['title'] = __('cmn.challan_paid');
            $data['sub_menu'] = 'challan_paid';
             
            $query = TripChallan::query()->with('trip')
                            ->where('for', 'company_trip');

            if($request->input('trip_number')){
                $query->whereHas('trip', function($subQuery) use($request) {
                    $subQuery->where('number', $request->input('trip_number'));
                });
            }

            if($request->input('voucher_id')){
                $query = $query->where('voucher_id', 'like', '%' . $request->input('voucher_id') . '%');
            }
        
            if($request->input('vehicle_number')){
                $query->whereHas('trip.provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_number', 'like', '%' . $request->input('vehicle_number') . '%');
                });
            }

            if($request->input('vehicle_id')){
                $query->whereHas('trip.provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_id', $request->input('vehicle_id'));
               });
            }

            if($request->input('order_by')){ 
                if($request->input('order_by') == 'asc'){
                    $query = $query->orderBy('date','ASC');
                }
                if($request->input('order_by') == 'desc'){
                    $query = $query->orderBy('date','DESC');
                }
            }

            if($request->input('per_page')){ 
                $data['challans'] = $query->paginate($request->input('per_page'));
            } else {
                $data['challans'] = $query->paginate(50);
                $request['per_page']=50;
            }

            return view('company.paid_list', $data);
        }
        if($request->input('page_name') == 'demarage_due'){
            $data['top_title'] = __('cmn.company').' '.__('cmn.demarage_due');
            $data['title'] = __('cmn.company').' '.__('cmn.demarage_due');
            $data['sub_menu'] = 'demarage_due';
            $data['accounts'] = Account::orderBy('sort', 'asc')->get();
            $query = Trip::query()->with('vehicle','getTripsByGroupId');
            $query->whereHas('company', function($subQuery) {
                $subQuery->where('demarage_due','>',0);
            });
            if($request->input('number')){
                $query->where('number', $request->input('number'));
            }
            if($request->input('vehicle_number')){
                $query->whereHas('provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_number', $request->input('vehicle_number'));
                });
            }
            $data['trips'] = $query->orderBy('date','desc')->paginate(1000);
            $data['form_url'] = 'due-payment-received-from-company';
            $data['payment_type'] = 'demarage_due';
            return view('company.due_list', $data);
        }
        if($request->input('page_name') == 'demarage_paid'){
            $data['top_title'] = __('cmn.demarage_paid');
            $data['title'] = __('cmn.demarage_paid');
            $data['sub_menu'] = 'demarage_paid';

            $query = TripChallan::query()->with('trip')
                            ->where('for', 'company_demarage');

            if($request->input('trip_number')){
                $query->whereHas('trip', function($subQuery) use($request) {
                    $subQuery->where('number', $request->input('trip_number'));
                });
            }

            if($request->input('voucher_id')){
                $query = $query->where('voucher_id', 'like', '%' . $request->input('voucher_id') . '%');
            }
        
            if($request->input('vehicle_number')){
                $query->whereHas('trip.provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_number', 'like', '%' . $request->input('vehicle_number') . '%');
                });
            }

            if($request->input('vehicle_id')){
                $query->whereHas('trip.provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_id', $request->input('vehicle_id'));
               });
            }

            if($request->input('order_by')){ 
                if($request->input('order_by') == 'asc'){
                    $query = $query->orderBy('date','ASC');
                }
                if($request->input('order_by') == 'desc'){
                    $query = $query->orderBy('date','DESC');
                }
            }

            if($request->input('per_page')){ 
                $data['challans'] = $query->paginate($request->input('per_page'));
            } else {
                $data['challans'] = $query->paginate(50);
                $request['per_page']=50;
            }

            return view('company.paid_list', $data);
        }
        if($request->input('page_name') == 'reports'){
            $data['top_title'] = __('cmn.report_form_of_company_billing');
            $data['title'] = __('cmn.report_form_of_company_billing');
            $data['sub_menu'] = 'report';
            $data['request'] = $request;
            // $data['vehicles'] = SettingVehicle::all();
            $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
            $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
            return view('company.report_form', $data);
        }
    }

    // TripTransectionRequest
    // Request
    // public function duePaymentReceivedFromCompany(TripTransectionRequest $request){


    //     DB::beginTransaction();
    //     try {

    //         // request assign
    //         $amount = $request->input('amount');
    //         $date = $request->input('date');
    //         $recipients_name = $request->input('recipients_name');
    //         $recipients_phone = $request->input('recipients_phone');
    //         $payment_type = $request->input('payment_type');
    //         $account_id = $request->input('account_id');
            
    //         if($request->has('up_down_status')){

    //             // first trip id always consider as up trip
    //             $trip_ids = Trip::where('group_id', $request->input('group_id'))->select('id')->get()->toArray();
    //             if(count($trip_ids) > 0){

    //                 if($request->input('up_down_status') == 'up'){

    //                     $up_trip = Trip::with('company')->where('id', $trip_ids[0]['id'])->first();
    //                     $trip_id = $up_trip->id;
    //                     $company_id = $up_trip->company->company_id;

    //                 } else {

    //                     $down_trip = Trip::with('company')->where('id', $trip_ids[1]['id'])->first();
    //                     $trip_id = $down_trip->id;
    //                     $company_id = $down_trip->company->company_id;
    //                 }

    //             } else {
    //                 Toastr::error('',__('cmn.up_down_challan_trip_not_found'));
    //                 return redirect()->back();
    //             }
    //         } else {
    //             // when request from non other trip type
    //             $trip_id = $request->input('trip_id');
    //             $company_id = $request->input('company_id');
    //         }

    //         // fetch trip company
    //         if(TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->exists()){

    //             $tripCompany = TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->first();

    //         } else {
    //             Toastr::error('', __('cmn.trip_or_company_data_not_found'));
    //             return redirect()->back();
    //         }

    //         // due amount fetch from database
    //         switch ($payment_type) {
    //             case 'challan_due':
    //                 $due_amount = $tripCompany->due_fair;
    //                 break;
    //             case 'demarage_due':
    //                 $due_amount = $tripCompany->demarage_due;
    //                 break;
    //         }
            
    //         // if due amount 0 then return back
    //         if($due_amount == 0){
    //             Toastr::error('', __('cmn.no_due'));
    //             return redirect()->back();
    //         }
            
    //         // if due posting amount is greate then due amount
    //         if($amount > $due_amount){
    //             Toastr::error('',  __('cmn.the_post_amount_is_more_than_the_due_amount_so_posting_is_not_valid'));
    //             return redirect()->back();
    //         }

    //         // amount increase from database
    //         switch ($payment_type) {
    //             case 'challan_due':
    //                 $left_amount = $due_amount - $amount;
    //                 $tripCompany->received_fair += $amount; // increase deposit
    //                 $tripCompany->due_fair = $left_amount; // decrease due
    //                 $for = 'challan_bill_has_been_received_from_the_company_for_the_trip';
    //                 break;
                    
    //             case 'demarage_due':
    //                 $left_amount = $due_amount - $amount;
    //                 $tripCompany->demarage_received += $amount;
    //                 $tripCompany->demarage_due = $left_amount; // decrease due
    //                 $for = 'demarage_has_been_received_from_the_company_for_the_trip';
    //                 break;
    //         }
    //         $tripCompany->save();

    //         // transection
    //         $trans['account_id'] = $account_id;
    //         $trans['amount'] = $amount;
    //         $trans['type'] = 'in';
    //         $trans['date'] = $date;
    //         $trans['transactionable_id'] = $tripCompany->trip_id;
    //         $trans['transactionable_type'] = 'trip';
    //         $trans['for'] = $for;
    //         $transaction = $this->transaction($trans);

    //         // pivot table transection
    //         switch ($payment_type) {
    //             case 'challan_due':
    //                 $challan_for = 'company_trip';
    //                 break;
                    
    //             case 'demarage_due':
    //                 $challan_for = 'company_demarage';
    //                 break;
    //         }
    //         $tripChallanModel = new TripChallan();
    //         $tripChallanFillData = collect($request->only($tripChallanModel->getFillable()));
    //         $tripChallanFinalData = $tripChallanFillData->merge(['trip_id' => $tripCompany->trip_id,
    //                                             'account_transection_id' => $transaction->id,
    //                                             'for'=> $challan_for])->toArray();
    //         $tripChallanModel->create($tripChallanFinalData);

    //         // account update
    //         $account = Account::where('id', $trans['account_id']);
    //         $account->increment('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);

    //         DB::commit();
    //         Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
    //         return redirect()->back();
    //     }catch (ModelNotFoundException $e) {
    //         DB::rollback();
    //         // dd($e->message());
    //         Toastr::error(__('cmn.sorry'), $e->message());
    //         return redirect()->back();
    //     }
    // }

    public function report(Request $request){

        // dd($request);
        ini_set('max_execution_time', '600'); // 10 minutes
        ini_set("pcre.backtrack_limit", "5000000");

        $data['title'] = __('cmn.'. $request->input('report_name')) .' '. __('cmn.report') . ' - ';

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
        $data['title'] .= $title;
        $data['menu'] = 'company';
        $data['sub_menu'] = 'report';
        $data['reporting_time'] = date('d M, Y h:i:s a');

        $query = $query = Trip::query()->with('company','provider');

        if($request->input('paid_status') == 'due_challan'){
            $query =  $query->whereHas('company', function($subQuery) {
                $subQuery->where('due_fair','>',0);
            });
        }

        if($request->input('paid_status') == 'paid_challan'){
            $query =  $query->whereHas('company', function($subQuery) {
                $subQuery->where('due_fair',0);
            });
        }

        if($request->input('demarage_status') == 'due_demarage'){
            $query = $query->whereHas('company', function($subQuery) {
                $subQuery->where('demarage_due','>',0);
            });
        }

        if($request->input('demarage_status') == 'paid_demarage'){
            $query = $query->whereHas('company', function($subQuery) {
                $subQuery->where('demarage_due','==',0);
            });
        }  

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

        $data['lists'] = $query->get();

        $data['top_title'] = $data['title'];

        // if($request->has('share') && $request->input('share') == 'true'){

        //     // try catch

        //     $full_url = url()->full();
        //     $parsedUrl = parse_url($full_url);

        //     // $parsedUrl['post']; // www.example.com
        //     // $parsedUrl['path']; // /posts
        //     // $parsedUrl['query'];

        //     $shareModel = new Share();
        //     $shareModel->encrypt = uniqid();
        //     $shareModel->filter = $parsedUrl['query'];
        //     $shareModel->validity = $request->input('validity')??1;
        //     $shareModel->created_by = Auth::user()->id;
        //     $shareModel->save();

        //     return redirect('public/' . $shareModel->encrypt);

        // }

        if($request->input('report_name') == 'company_billing' || $request->has('demarage_status')){
            $pdf = PDF::loadView('company.report.company_billing_report_pdf', $data);
            if($request->input('download_pdf') == 'true'){
                return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            } else {
                return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            }
        }

    }


}