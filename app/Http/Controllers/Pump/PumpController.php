<?php

namespace App\Http\Controllers\Pump;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Traits\AccountTransTrait;

use App\Models\Trips\Trip;
use App\Models\Trips\TripProvider;
use App\Models\Trips\TripOilExpense;
use App\Models\Settings\SettingPump;
use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingCompany;

use PDF;
// service
use App\Services\CommonService;


class PumpController extends Controller{

    use AccountTransTrait;

    public function __construct(){
        $this->middleware('auth');
    }

    function index(Request $request){
        $data['request'] = $request;
        $data['menu'] = 'pump';

        // $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
        // $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');

        $data['unique_provider_driver_names'] = TripProvider::latest()->get(['driver_name'])->unique('driver_name');
        $data['unique_provider_owner_names'] = TripProvider::latest()->get(['owner_name'])->unique('owner_name');
        $data['unique_provider_reference_names'] = TripProvider::latest()->get(['reference_name'])->unique('reference_name');
        // $data['unique_voucher_ids'] = TripChallan::latest()->get(['voucher_id'])->unique('voucher_id');

        if($request->input('page_name') == 'pump_list'){
            $data['top_title'] = __('cmn.pump_list');
            $data['title'] =  __('cmn.pump_list');
            $data['sub_menu'] = 'pump_list';
            $data['request'] = $request;

            $query = SettingPump::query();
            if($request->name_phone){
                $query = $query->where('name', 'like', '%' . $request->name_phone . '%')
                            ->orWhere('phone', 'like', '%' . $request->name_phone . '%');
            }
            $data['lists'] = $query->orderBy('sort', 'asc')->paginate(50);
            return view('pump.pump_list', $data);
        }

        if($request->input('page_name') == 'pump_reports'){
            $data['top_title'] = __('cmn.report_form_of_pump_billing');
            $data['title'] = __('cmn.report_form_of_pump_billing');
            $data['sub_menu'] = 'report';
            $data['request'] = $request;

            $data['vehicles'] = SettingVehicle::all();
            $data['companies'] = SettingCompany::orderBy('sort', 'asc')->get();


            $data['unique_challan_numbers'] = Trip::latest()->get(['number'])->unique('number');
            $data['unique_vehicle_numbers'] = TripProvider::latest()->get(['vehicle_number'])->unique('vehicle_number');
            
            return view('pump.report_form', $data);
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
        $data['menu'] = 'company';
        $data['sub_menu'] = 'report';
        $data['reporting_time'] = date('d M, Y h:i:s a');

        // $query = $query = Trip::query()->with('company','provider');
        $query = $query = TripOilExpense::query()->with('pump','trip');

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
            $query->whereHas('trip.company', function($subQuery) use($request) {
                    $subQuery->where('company_id',$request->input('company_id'));
            });
            $company = SettingCompany::where('id', $request->input('company_id'))->select('name')->first();
            $data['title'] .= ' - (' . __('cmn.company_name') .'- ' .$company->name. ')';
        }

        if($request->input('vehicle_number')){
            $query->whereHas('trip.provider', function($subQuery) use($request) {
                $subQuery->where('vehicle_number','like', '%' . $request->input('trip_number') . '%');
            });
            $data['title'] .= ' - (' . __('cmn.vehicle_number') .'- ' .$request->input('vehicle_number'). ')';
        }

        if($request->input('provider_driver')){
            $query->whereHas('trip.provider', function($subQuery) use($request) {
                $subQuery->where('driver_name', 'like', '%' . $request->input('provider_driver') . '%');
            });
            $data['title'] .= ' - (' . __('cmn.driver') .'- ' .$request->input('provider_driver'). ')';
        }

        if($request->input('provider_owner')){
            $query->whereHas('trip.provider', function($subQuery) use($request) {
                $subQuery->where('owner_name', 'like', '%' . $request->input('provider_owner') . '%');
            });
            $data['title'] .= ' - (' . __('cmn.owner') .'- ' .$request->input('provider_owner'). ')';
        }

        if($request->input('provider_reference')){
            $query->whereHas('trip.provider', function($subQuery) use($request) {
                $subQuery->where('reference_name', 'like', '%' . $request->input('provider_reference') . '%');
            });
            $data['title'] .= ' - (' . __('cmn.reference') .'- ' .$request->input('provider_reference'). ')';
        }

        if($request->input('vehicle_id')){
            $query->whereHas('trip.provider', function($subQuery) use($request) {
                $subQuery->where('vehicle_id', $request->input('vehicle_id'));
            });
            $vehicle = SettingVehicle::where('id', $request->input('vehicle_id'))->select('vehicle_number')->first();
            $data['title'] .= ' - (' . __('cmn.vehicle_number') .'- ' .$vehicle->vehicle_number. ')';
        }

        if($request->input('trip_number')){
            $query->whereHas('trip', function($subQuery) use($request) {
                $subQuery->where('number','like', '%' . $request->input('trip_number') . '%');
            });
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

        if($request->input('report_name') == 'pump_billing'){
            $pdf = PDF::loadView('pump.report.pump_billing_report_pdf', $data);
            if($request->input('download_pdf') == 'true'){
                return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            } else {
                return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            }
        }
    }


}