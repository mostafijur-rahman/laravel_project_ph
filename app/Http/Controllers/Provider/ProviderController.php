<?php

namespace App\Http\Controllers\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\Trip\TripTransectionRequest;

use App\Http\Traits\AccountTransTrait;

use App\Models\Trips\Trip;
use App\Models\Trips\TripProvider;
use App\Models\Trips\TripChallan;
use App\Models\Accounts\Account;
use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingCompany;

use App\Services\CommonService;


use DB;
use Auth;
use Toastr;
use Carbon\Carbon;
use PDF;

class ProviderController extends Controller{

    use AccountTransTrait;

    public function __construct(){
        $this->middleware('auth');
    }

    function index(Request $request){
        $data['request'] = $request;
        $data['menu'] = 'provider';
        $data['vehicles'] = SettingVehicle::all();
        $data['companies'] = SettingCompany::orderBy('sort', 'asc')->get();

        $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
        $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');

        $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
        $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
        $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');
        $data['unique_voucher_ids'] = TripChallan::latest()->get(['voucher_id'])->unique('voucher_id');

        if($request->input('page_name') == 'challan_due'){
            $data['top_title'] = __('cmn.challan_due');
            $data['title'] = __('cmn.challan_due');
            $data['sub_menu'] = 'challan_due';
            $data['accounts'] = Account::orderBy('sort', 'asc')->get();

            $data['form_url'] = 'due-payment-to-provider';
            $data['payment_type'] = 'challan_due';

            $query = Trip::query()->with('vehicle')->whereHas('provider', function($subQuery) {
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

            // if($request->input('show_type') == 'trip_number'){
            //     $data['trips'] = $query->orderBy('date','desc')->paginate(50);
            //     return view('provider.due_list_payment_date', $data);
            // }

            $data['trips'] = $query->orderBy('date','desc')->paginate(50);
            return view('provider.due_list_payment_date', $data);
        }
        if($request->input('page_name') == 'challan_paid'){
            $data['top_title'] = __('cmn.challan_paid');
            $data['title'] = __('cmn.challan_paid');
            $data['sub_menu'] = 'challan_paid';
            $data['page_name'] = 'challan_paid';

            $query = TripChallan::query()->where('for', 'provider_trip');

            if($request->input('vehicle_number')){
                $query = $query->whereHas('trip.provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_number', 'like', '%' . $request->input('vehicle_number') . '%');
                });
            }

            // if($request->input('vehicle_id')){
            //     $query->whereHas('provider', function($subQuery) use($request) {
            //         $subQuery->where('vehicle_id', $request->input('vehicle_id'));
            //    });
            // }

            if($request->input('trip_number')){
                $query = $query->whereHas('trip', function($subQuery) use($request) {
                    $subQuery->where('number', 'like', '%' . $request->input('trip_number') . '%');
                });
            }

            if($request->input('voucher_id')){
                $query = $query->where('voucher_id', 'like', '%' . $request->input('voucher_id') . '%');
            }

            if($request->input('show_type') == 'trip_number_wise'){ 
                if($request->input('order_by')){ 
                    if($request->input('order_by') == 'asc'){
                        $query = $query->orderBy('trip_id','ASC');
                    }
                    if($request->input('order_by') == 'desc'){
                        $query = $query->orderBy('trip_id','DESC');
                    }
                } else {
                    $query = $query->orderBy('trip_id', 'DESC');
                }
            }

            if($request->input('show_type') == 'trip_date_wise'){

                if($request->input('order_by')){ 
                    if($request->input('order_by') == 'asc'){
                        $query = $query->orderBy('date','ASC');
                    }
                    if($request->input('order_by') == 'desc'){
                        $query = $query->orderBy('date','DESC');
                    }
                } else {
                    $query = $query->orderBy('date', 'DESC');
                }
            }

            $data['challans'] = $query->Paginate(100);
            return view('provider.paid_list', $data);

        }
        if($request->input('page_name') == 'demarage_due'){
            $data['top_title'] = __('cmn.provider').' '.__('cmn.demarage_due');
            $data['title'] = __('cmn.provider').' '.__('cmn.demarage_due');
            $data['sub_menu'] = 'demarage_due';
            $data['accounts'] = Account::orderBy('sort', 'asc')->get();
            $query = Trip::query()->with('vehicle','getTripsByGroupId')->whereHas('provider', function($subQuery) {
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
            $data['trips'] = $query->orderBy('date','desc')->paginate(50);
            $data['form_url'] = 'due-payment-to-provider';
            $data['payment_type'] = 'demarage_due';
            return view('provider.due_list_payment_date', $data);
        }
        if($request->input('page_name') == 'demarage_paid'){
            $data['top_title'] = __('cmn.provider').' '.__('cmn.demarage_paid');
            $data['title'] = __('cmn.provider').' '.__('cmn.demarage_paid');
            $data['sub_menu'] = 'demarage_paid';

            $query = TripChallan::query()->where('for', 'provider_demarage');

            if($request->input('vehicle_number')){
                $query = $query->whereHas('trip.provider', function($subQuery) use($request) {
                    $subQuery->where('vehicle_number', 'like', '%' . $request->input('vehicle_number') . '%');
                });
            }

            // if($request->input('vehicle_id')){
            //     $query->whereHas('provider', function($subQuery) use($request) {
            //         $subQuery->where('vehicle_id', $request->input('vehicle_id'));
            //    });
            // }

            if($request->input('trip_number')){
                $query = $query->whereHas('trip', function($subQuery) use($request) {
                    $subQuery->where('number', 'like', '%' . $request->input('trip_number') . '%');
                });
            }

            if($request->input('voucher_id')){
                $query = $query->where('voucher_id', 'like', '%' . $request->input('voucher_id') . '%');
            }

            if($request->input('show_type') == 'trip_number_wise'){ 
                if($request->input('order_by')){ 
                    if($request->input('order_by') == 'asc'){
                        $query = $query->orderBy('trip_id','ASC');
                    }
                    if($request->input('order_by') == 'desc'){
                        $query = $query->orderBy('trip_id','DESC');
                    }
                } else {
                    $query = $query->orderBy('trip_id', 'DESC');
                }
            }

            if($request->input('show_type') == 'trip_date_wise'){

                if($request->input('order_by')){ 
                    if($request->input('order_by') == 'asc'){
                        $query = $query->orderBy('date','ASC');
                    }
                    if($request->input('order_by') == 'desc'){
                        $query = $query->orderBy('date','DESC');
                    }
                } else {
                    $query = $query->orderBy('date', 'DESC');
                }
            }

            $data['challans'] = $query->Paginate(100);
            $data['page_name'] = 'demarage_paid';
            return view('provider.paid_list', $data);
        }
        if($request->input('page_name') == 'reports'){
            $data['top_title'] = __('cmn.provider_billing_report');
            $data['title'] = __('cmn.provider_billing_report');
            $data['sub_menu'] = 'report';
            $data['request'] = $request;
            $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
            $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
            $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
            return view('provider.report_form', $data);
        }
    }

    public function duePaymentToProvider(TripTransectionRequest $request){
        // dd($request);

        if($request->input('amount') > Account::find($request->input('account_id'))->balance){
            Toastr::error('',__('cmn.there_is_no_balance_in_the_senders_account_so_the_balance_transfer_is_not_acceptable'));
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            $amount = $request->input('amount');
            $trip_id = $request->input('trip_id');
            $date = $request->input('date');
            $recipients_name = $request->input('recipients_name');
            $recipients_phone = $request->input('recipients_phone');
            $payment_type = $request->input('payment_type');

            if($trip_id){
                $query = TripProvider::query()->whereIn('trip_id', $trip_id);
                if($payment_type=='challan_due'){
                    $query = $query->where('due_fair', '>', 0);
                } else {
                    $query = $query->where('demarage_due', '>', 0);
                }
                $tripProviders = $query->get();
            }

            $due_amount_sum = ($payment_type=='challan_due')?$tripProviders->sum('due_fair'):$tripProviders->sum('demarage_due');

            if($due_amount_sum == 0){
                Toastr::error('', __('cmn.no_due'));
                return redirect()->back();
            }
            
            if($amount != $due_amount_sum){
            // if($amount > $due_amount_sum){
                Toastr::error('', 'পরিশোধ করতে হবে '.number_format($due_amount_sum).' টাকা আর আপনি পোস্টিং দিচ্ছেন '. number_format($amount) .' টাকা, তাই পোস্টিং টি গ্রহণ যোগ্য হলো না !');
                return redirect()->back();
            }
            if(count($tripProviders)>0){
                $due_amount = 0;
                foreach ($tripProviders as $tripProvider) {
                    $due_amount = ($payment_type=='challan_due')?$tripProvider->due_fair:$tripProvider->demarage_due;
                    Toastr::success('', 'বিল হিসাবে '. number_format($due_amount) .' টাকা পরিশোদ করা হলো');
                    Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
                    if($payment_type=='challan_due'){
                        $tripProvider->received_fair += $due_amount; // increase deposit
                        $tripProvider->due_fair = 0; // decrease due
                        $for = 'the_vehicle_provider_has_been_paid_the_challan_due_for_the_trip';
                    } else {
                        $tripProvider->demarage_received += $due_amount;
                        $tripProvider->demarage_due = 0; // decrease due
                        $for = 'the_vehicle_provider_has_been_paid_demarage_for_the_trip';
                    }
                    $tripProvider->save();
                    
                    // transection
                    $trans['account_id'] = $request->input('account_id');
                    $trans['amount'] = $due_amount;
                    $trans['type'] = 'out';
                    $trans['date'] = $date;
                    $trans['transactionable_id'] = $tripProvider->trip_id;
                    $trans['transactionable_type'] = 'trip';
                    $trans['for'] = $for;
                    $transaction = $this->transaction($trans);

                    // pivot table transection
                    $tripChallanModel = new TripChallan();
                    $tripChallanFillData = collect($request->only($tripChallanModel->getFillable()));
                    $tripChallanFinalData = $tripChallanFillData->merge(['trip_id' => $tripProvider->trip_id,
                                                        'account_transection_id' => $transaction->id,
                                                        'for'=> ($payment_type=='challan_due')?'provider_trip':'provider_demarage'])->toArray();
                    $tripChallanModel->create($tripChallanFinalData);
                    
                    // account update
                    $account = Account::where('id', $trans['account_id']);
                    $account->decrement('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);
                    
                    $amount -= ($payment_type=='challan_due')?$tripProvider->due_fair:$tripProvider->demarage_due;
                }
            } else {
                Toastr::error('', __('cmn.must_select_trip'));
                return redirect()->back();
            }
            DB::commit();
            return redirect()->back();
        }catch (ModelNotFoundException $e) {
            DB::rollback();
            dd($e->message());
            Toastr::error(__('cmn.sorry'), $e->message());
            return redirect()->back();
        }
    }

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
        $data['menu'] = 'provider';
        $data['sub_menu'] = 'report';
        $data['reporting_time'] = date('d M, Y h:i:s a');

        $query = $query = Trip::query()->with('company','provider');

        if($request->input('paid_status') == 'due_challan'){
            $query =  $query->whereHas('provider', function($subQuery) {
                $subQuery->where('due_fair','>',0);
            });
        }

        if($request->input('paid_status') == 'paid_challan'){
            $query =  $query->whereHas('provider', function($subQuery) {
                $subQuery->where('due_fair',0);
            });
        }

        if($request->input('demarage_status') == 'due_demarage'){
            $query = $query->whereHas('provider', function($subQuery) {
                $subQuery->where('demarage_due','>',0);
            });
        }

        if($request->input('demarage_status') == 'paid_demarage'){
            $query = $query->whereHas('provider', function($subQuery) {
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

        // dd($data['lists']);

        if($request->input('report_name') == 'provider_billing' || $request->has('demarage_status')){
            $pdf = PDF::loadView('provider.report.provider_billing_report_pdf', $data);
            if($request->input('download_pdf') == 'true'){
                return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            } else {
                return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            }
        }
    }

}