<?php

namespace App\Http\Controllers\Tyre;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Toastr;
use Carbon\Carbon;
use DB;
use PDF;

use App\Models\Tyres\Tyre;
use App\Models\Mobils\Mobil;
use App\Models\Purchases\Purchase;
use App\Models\Settings\SettingVehicle;
use App\Services\CommonService;

class TyreController extends Controller
{

    public function index(Request $request)
    {
        $data['request'] = $request;
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.tyre_notification').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.tyre_notification').' '.__('cmn.page');
        $data['menu'] = 'tyres';
        $data['vehicles'] = SettingVehicle::all();

        $query = Tyre::query()->with('purchase','vehicle', 'created_user', 'updated_user');
        if($request->input('page_name')){
            if($request->input('page_name') == 'attached'){
                $query = $query->whereNotNull('attach_date');
                $data['sub_menu'] = 'attached';
            } else {
                $query = $query->whereNull('attach_date');
                $data['sub_menu'] = 'not_attached';
            }
            if($request->input('page_name') == 'reports'){
                $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.transection').' '.__('cmn.report').' '.__('cmn.page');
                $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.transection').' '.__('cmn.report').' '.__('cmn.page');
                $data['sub_menu'] = 'report';
                $data['request'] = $request;
                $data['vehicles'] = [];
                $data['accounts'] = SettingVehicle::orderBy('id','desc')->paginate(50);
                return view('tyre.report_form', $data);
            }
        }
        $data['tyres'] = $query->orderBy('attach_date', 'desc')->Paginate(60);
        return view('tyre.tyres', $data);
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            // create goods record
            if($request->input('form_type') == 'tyre'){
                $tyreModel = new Tyre();
                $fillableData = collect($request->only($tyreModel->getFillable()));
                $finalData = $fillableData->merge(['encrypt'=> uniqid(),'created_by'=> Auth::user()->id]);
                $tyre = $tyreModel->create($finalData->toArray());
            }elseif($request->input('form_type') == 'mobil'){
                $mobilModel = new Mobil();
                $fillableData = collect($request->only($mobilModel->getFillable()));
                $finalData = $fillableData->merge(['encrypt'=> uniqid(),'created_by'=> Auth::user()->id]);
                $tyre = $mobilModel->create($finalData->toArray());
            } else {
                Toastr::error(__('cmn.something_went_wrong'),__('cmn.sorry'));
                return redirect()->back();
            }
            // create purchase
            $purchaseModel = new Purchase();
            $fillableData = collect($request->only($purchaseModel->getFillable()));
            $finalData = $fillableData->merge([
                'encrypt'=> uniqid(),
                'purchaseable_type'=> $request->input('form_type'),
                'purchaseable_id'=> $tyre->id,
                'created_by'=> Auth::user()->id
            ]);
            $purchaseModel->create($finalData->toArray());
            // transection code will here
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
        // $acc['code'] = $data->trip_comn_exp_encrypt;
        // $acc['table'] = $data->getTable();
        // $acc['table_id'] = $data->id;
        // $acc['head'] = 'general_expenses';
        // $acc['cash_out'] = $request->amount;

        // try {
        //     $this->account_transaction($acc);
        // } catch (Exception $e) {
        //     DB::rollback();
        //     Toastr::error('',$e->message());
        //     return redirect()->back();
        // }

        Toastr::success(__('cmn.successfully_added'), __('cmn.success'));
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'attach_date' => "required",
            'vehicle_id' => "required",
        ]);
        try {
            $tyreModel = new Tyre();
            $fillableData = collect($request->only($tyreModel->getFillable()));
            $tyreModelData = Tyre::where('id', $id)->first();
            $finalData = $fillableData->merge(['updated_by'=> Auth::user()->id]);   
            $tyreModelData->update($finalData->toArray());
            Toastr::success(__('cmn.successfully_updated'),__('cmn.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            Toastr::error(__('cmn.did_not_updated'),__('cmn.sorry'));
            return redirect()->back();
        }
    }
    public function report(Request $request){

        Toastr::error('',__('cmn.this_feature_has_been_disabled'));
        return redirect()->back();
        $data['reporting_time'] = date('d M, Y h:i:s a');
        $data['title'] =  __('cmn.expense_report');
        $data['menu'] = 'report';
        $data['sub_menu'] = 'tyre_report';
        $data['request'] = $request;
        $date_range_status = $request->input('date_range_status');
        $month = $request->input('month');
        $year = $request->input('year');
        $expense_id =  $request->input('expense_id');
        $vehicle_id = $request->input('vehicle_id');
        $date_range_status = $request->input('date_range_status');
        $daterange = $request->input('daterange');

        $query = Tyre::query()->with('purchase','vehicle', 'created_user', 'updated_user');
        
        // if($expense_id){
        //     $expense = SettingVehicle::where('id', $expense_id)->first();
        //     $data['title'] .= ' ('. __('cmn.expense_head') . ' - ' .  $expense->head . ')';
        //     $query = $query->where('expense_id', $expense_id);
        // }
        // if($vehicle_id){
        //     $vehicle = SettingVehicle::where('id', $vehicle_id)->first();
        //     $data['title'] .= ' ('. __('cmn.vehicle_number') . ' - ' .  $vehicle->vehicle_number . ')';
        //     $query = $query->where('vehicle_id', $vehicle_id);
        // }
         // mothly report start
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
        if($date_range_status == 'yearly_report'){
            if(!$year){
                Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                return redirect()->back();
            }
            $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
            $query = $query->whereYear('date',$year);
        }

        if($date_range_status == 'date_wise' && $daterange){
            
            $date = explode(' - ', $daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
            
            $query = $query->whereBetween('date', [$start_date, $end_date]);
        }
        // yearly_report_end
        $data['lists'] = $query->get();
        // return view('expense.report.expense_report', $data);
        $pdf = PDF::loadView('tyre.report.tyre_report_pdf', $data);
        if($request->input('download_pdf') == 'true'){
            return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        } else {
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }
    }

  

}
