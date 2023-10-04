<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Trips\Trip;
use App\Models\Settings\SettingCompany;
use App\Models\Settings\SettingVehicle;
use App\Models\Dues\DueCollection;
use App\Http\Traits\TransectionTrait;

use App\Http\Requests\Payment\PaymentRequest;

use DB;
use Auth;
use Toastr;
use Carbon\Carbon;
use PDF;

class PaymentController extends Controller
{
    use TransectionTrait;
    public function index(Request $request)
    {
        if($request->input('type') == 'company'){
            $data['menu'] = 'payment';
            if($request->input('page') && $request->input('page') == 'trip-deposit'){
                $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.trip_deposit').' '.__('cmn.page');
                $data['title'] =  __('cmn.now_you_are_on_the') .' '.__('cmn.trip_deposit').' '.__('cmn.page');
                $data['sub_menu'] = 'payment_company';
                $data['company'] = SettingCompany::with('tripDueFairHistories')->where('encrypt', $request->input('id'))->first();
                $data['deposits'] = DueCollection::where('company_id', $data['company']->id)->orderBy('date', 'desc')->paginate(50);
                $data['vehicles'] = SettingVehicle::orderBy('sort', 'asc')->get();
                $data['trips'] = Trip::with('vehicle','getTripsByGroupId', 'oilExpenses.pump', 'meter')
                                ->where('company_id', $data['company']->id)
                                ->where('due_fair','>',0)
                                ->groupBy('group_id')->orderBy('group_id','asc')->paginate(50);
                if(empty($data['company'])){
                    Toastr::error(__('cmn.did_not_find'),__('cmn.sorry'));
                    return redirect()->back();
                }
                return view('payment.trip_deposit', $data);
            }

            if($request->input('history') && $request->input('history') == 'deposit'){
                $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.trip_deposit_history').' '.__('cmn.page');
                $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.trip_deposit_history').' '.__('cmn.page');
                $data['sub_menu'] = 'payment_company';
                $data['company'] = SettingCompany::with('tripDueFairHistories')->where('encrypt', $request->input('id'))->first();
                $data['deposits'] = DueCollection::where('company_id', $data['company']->id)->orderBy('date', 'desc')->paginate(50);
                if(empty($data['company'])){
                    Toastr::error(__('cmn.did_not_find'),__('cmn.sorry'));
                    return redirect()->back();
                }
                return view('payment.deposit_history', $data);
            }

            $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.company_billing').' '.__('cmn.page');
            $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.company_billing').' '.__('cmn.page');
            $data['sub_menu'] = 'payment_company';
            $data['lists'] = SettingCompany::with('tripDueFairHistories')->orderBy('sort','asc')->get();
            return view('payment.company_list', $data);
        }
        // else  sippliers will here

    }

    public function paymentCollection(Request $request){

    
        // dd($request);
        // "company_id" => "1"
        // "business_type" => "trip"
        // "group_id" => 
        // "date" => "2021-10-31"
        // "amount" => "1000"

        // if(!$request->input('group_id')){
        //     Toastr::error('', __('cmn.must_select_trip'));
        //     return redirect()->back();
        // }

        if($request->input('amount')<=0){
            Toastr::error('', __('cmn.give_the_correct_amount'));
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            $companyId = $request->input('company_id');
            $amount = $request->input('amount');
            $group_id = $request->input('group_id');
            $trips = [];
            $tripDetailsArray = [];
            if($group_id){
                $trips =  Trip::where('company_id', $companyId)
                                ->whereIn('group_id', $group_id)
                                ->where('due_fair', '>', 0)
                                ->orderBy('date','asc')
                                ->get(); 
            }
            if($trips){
                // trip deposit
                foreach ($trips as $trip) {
                    try {
                        if($trip->due_fair >= $amount){
                            $tripDetailsArray[] = ['trip_id'=>$trip->id, 'amount'=>$amount];
                            $trip->received_fair += $amount; // increase deposit
                            $trip->due_fair = $trip->due_fair - $amount; // decrease due
                            $trip->save();
                            Toastr::success('',__('cmn.amount_taka_has_been_deposited_for_trip_no_number', ['amount' => $amount, 'trip_id' => $trip->id]));
                            $amount = 0;
                            break;
                        }elseif($trip->due_fair < $amount){
                            $tripDetailsArray[] = ['trip_id'=> $trip->id, 'amount'=> (int) $trip->due_fair];
                            Toastr::success('',__('cmn.amount_taka_has_been_deposited_for_trip_no_number', ['amount' => (int) $trip->due_fair, 'trip_id' => $trip->id]));
                            $amount =  $amount - $trip->due_fair;
                            $trip->received_fair += $trip->due_fair;
                            $trip->due_fair = 0;
                            $trip->save();
                        }
                    } catch (ModelNotFoundException $e) {
                        DB::rollback();
                        Toastr::error(__('cmn.sorry'), $e->message());
                        return redirect()->back();
                    }

                }
            }
            // minus from prevous due balance
            if($amount > 0) {
                // $previous_balance_details_array = [];
                try {
                    $company = SettingCompany::find($companyId);
                    if($company->trip_receivable_amount<$amount){
                        Toastr::error('', __('cmn.amount_more_than_the_previous_deposit_has_been_deposited_so_the_deposit_was_not_accepted', ['amount' => number_format($amount-$company->trip_receivable_amount)]));
                        DB::rollback();
                        return redirect()->back();
                    }
                    $company->trip_receivable_amount -= $amount;
                    $company->save();
                    $tripDetailsArray[] = ['company_id'=>$company->id,'amount'=>$amount];
                    Toastr::success('',__('cmn.amount_was_deducted_from_the_previous_balance', ['amount' => $amount]));
                } catch (ModelNotFoundException $e) {
                    DB::rollback();
                    Toastr::error(__('cmn.sorry'), $e->message());
                    return redirect()->back();
                }
            }
            // Due Colllection saved
            try {
                $dueCollectionModel = new DueCollection();
                $fillableData = collect($request->only($dueCollectionModel->getFillable()));
                $finalData = $fillableData->merge(['encrypt'=> uniqid(),
                                            'business'=> 'trip',
                                            'company_id'=> $companyId,
                                            'amount_history'=> json_encode($tripDetailsArray),
                                            'created_by'=> Auth::user()->id]);
                $dueCollection = $dueCollectionModel->create($finalData->toArray());
            } catch (ModelNotFoundException $e) {
                DB::rollback();
                Toastr::error(__('cmn.sorry'), $e->message());
                return redirect()->back();
            }
            //transection here
            $trans['type'] = 'in';
            $trans['amount'] = $request->input('amount');
            $trans['method'] = 'cash';
            $trans['transactionable_id'] = $dueCollection->id;
            $trans['transactionable_type'] = 'due_collection';
            $this->transaction($trans);
            DB::commit();
            return redirect()->back();
        }catch (ModelNotFoundException $e) {
            DB::rollback();
            Toastr::error(__('cmn.sorry'), $e->message());
            return redirect()->back();
        }
    }

    public function paymentCollectionDelete($encrypt)
    {
        DB::beginTransaction();
        $data = DueCollection::where('encrypt', $encrypt)->first();
        $amount_history = json_decode($data->amount_history);
        foreach ($amount_history as $value) {
            if(isset($value->trip_id)){
                try {
                    $trip = Trip::find($value->trip_id);
                    $trip->received_fair -= $value->amount;
                    $trip->due_fair += $value->amount;
                    $trip->save();
                } catch (Exception $e) {
                    DB::rollback();
                    Toastr::error('', $e->message());
                    return redirect()->back();
                }
            } elseif (isset($value->company_id)){
                try {
                    $company = SettingCompany::find($value->company_id);
                    $company->trip_receivable_amount += $value->amount;
                    $company->save();
                } catch (Exception $e) {
                    DB::rollback();
                    Toastr::error('', $e->message());
                    return redirect()->back();
                }
            }
        }
        try {
            $data->delete();
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
        DB::commit();
        Toastr::success('',__('cmn.successfully_deleted'));
        return redirect()->back();
    }

    public function paymentReportForm(Request $request)
    {
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.company_billing').' '.__('cmn.page');
        $data['title'] = __('cmn.report_form_of_company_billing');
        $data['menu'] = 'report';
        $data['sub_menu'] = 'payment_report';
        $data['request'] = $request;
        $data['companies'] = SettingCompany::get();
        return view('payment.payment_report_form', $data);
    }

    public function paymentReport(Request $request)
    {

        $data['title'] = ''; // __('cmn.company_deposit')
        $data['menu'] = 'report';
        $data['sub_menu'] = 'payment_company';
        $data['lists'] = DueCollection::where('company_id', $request->input('company_id'))->orderBy('date', 'desc')->get();

        $data['reporting_time'] = date('d M, Y h:i:s a');
        if($request->input('type') == 'deposit'){
            $pdf = PDF::loadView('payment.report.payment_deposit_pdf', $data);
            if($request->input('download_pdf') == 'true'){
                return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            } else {
                return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            }
        }


        if($request->input('type') == 'transport_trip_list'){
            
            $pdf = PDF::loadView('payment.report.transport_trip_list_pdf', $data);
            // return view('payment.report.transport_trip_list_pdf', $data);
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }

        if($request->input('type') == 'transport_supplier_challan_report'){
            
            $pdf = PDF::loadView('payment.report.transport_supplier_challan_report_pdf', $data);
            // return view('payment.report.transport_trip_list_pdf', $data);
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }

        if($request->input('type') == 'transport_challan'){
            
            $pdf = PDF::loadView('payment.report.transport_challan_pdf', $data);
            // return view('payment.report.transport_trip_list_pdf', $data);
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }

        
        
    }

}