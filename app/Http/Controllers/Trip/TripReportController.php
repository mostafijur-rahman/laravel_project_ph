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

class TripReportController extends Controller {


    // this method user for all own vehicle summary report
    public function ownVehicleSummaryReport(Request $request){

        // dd($request);

        // "report_name" => "own_vehicle_summary"
        // "type" => "own_vehicle_single"
        // "order_by" => "asc"
        // "date_range_status" => "all_time"
        // "month" => null
        // "year" => null
        // "daterange" => null
        // "trip_number" => null
        // "vehicle_id" => null
        // "company_id" => null
        // "download_pdf" => "false"

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

            $pdf = PDF::loadView('trip.report.trip_single_pdf.common', $data);
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

            $pdf = PDF::loadView('trip.report.trip_single_pdf.common', $data);
            if($request->input('download_pdf') == 'true'){
                return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
            } else {
                return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
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

        // if($request->input('report_name') == 'challan'){
        //     $pdf = PDF::loadView('trip.report.trip_multi_pdf.common', $data);
        //     if($request->input('download_pdf') == 'true'){
        //         return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        //     } else {
        //         return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        //     }
        // }

        if($request->input('challan_type') == 'own_vehicle_single'){
            $pdf = PDF::loadView('trip.report_page.challan_summery.own_vehicle_single', $data);
        }

        if($request->input('challan_type') == 'own_vehicle_up_down'){
            $pdf = PDF::loadView('trip.report_page.challan_summery.own_vehicle_up_down', $data);
        }

        if($request->input('download_pdf') == 'true'){
            return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        } else {
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }


        // if($request->input('report_name') == 'challan_received_history'){
        //     $pdf = PDF::loadView('trip.report.challan_received_history_pdf', $data);
        //     if($request->input('download_pdf') == 'true'){
        //         return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        //     } else {
        //         return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        //     }
        // }


    }




}