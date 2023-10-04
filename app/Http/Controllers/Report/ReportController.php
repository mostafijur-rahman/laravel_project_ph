<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Trips\Trip;
use App\Models\Trips\TripOilExpense;
use App\Models\Expenses\Expense;
use App\Models\Settings\SettingVehicle;

use App\Services\CommonService;

use PDF;
use Toastr;
use Carbon\Carbon;


class ReportController extends Controller
{

    public function dailyAccountsReportForm(Request $request)
    {
        $data['title'] = __('cmn.report_form_of_daily_report');
        $data['menu'] = 'all_report';
        $data['sub_menu'] = 'daily_accounts';
        $data['request'] = $request;
        // $data['vehicles'] = SettingVehicle::all();
        return view('report.daily_accounts_report.report_form', $data);
    }

    // public function dailyAccountsReport(Request $request)
    // {
    //     $data['reporting_time'] = date('d M, Y h:i:s a');
    //     $data['title'] = __('cmn.daily_accounts');
    //     $data['menu'] = 'report';
    //     $data['menu'] = 'vehicl_report'; 
    //     $data['car_number'] = null;
    //     $data['request'] = $request;
    //     $vehicle_id = $request->input('vehicle_id');

    //     // deposites --------
    //     $trips = Trip::query()->orderBy('date','asc');
    //     // $due_collection = DueCollection::orderBy('date','asc');
    //     // $capitals = Capital::orderBy('id', 'desc');

    //     // expenses --------
    //     $expenses = Expense::query()->whereNull('trip_id')->orderBy('date','asc');
    //     // $pro_expenses = CarTotalProjectExpense::orderBy('car_total_project_exp_date','asc');
    //     // $inst_history = InstallmentHistory::orderBy('pay_date','asc')->get();

    //     // date range wise
    //     if ($request->has('date_range_status')) {
    //         $date_range_status = $request->input('date_range_status');
    //         $daterange = $request->input('daterange');
    //         $month = $request->input('month');
    //         $year = $request->input('year');
    //         // all time wise
    //         if($date_range_status == 'all_time'){
    //             $data['title'] .= ' - ' . __('cmn.all_time');
    //         }
    //         // date range wise
    //         if($date_range_status == 'date_wise' && $daterange){
    //             $date = explode(' - ', $daterange);
    //             $start_date = Carbon::parse($date[0])->startOfDay();
    //             $end_date = Carbon::parse($date[1])->endOfDay();
    //             $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
                
    //             // deposit -----
    //             $trips = $trips->whereBetween('account_take_date', [$start_date, $end_date]);
    //             // $due_collection = $due_collection->whereBetween('date', [$start_date, $end_date]);
    //             // $capitals = $capitals->whereBetween('date', [$start_date, $end_date]);

    //             // expense --------
    //             $expenses = $expenses->whereBetween('date', [$start_date, $end_date]);
    //             // $inst_history = $inst_history->whereBetween('pay_date', [$start_date, $end_date]);
    //         }
    //         // monthly report
    //         if($date_range_status == 'monthly_report'){
    //             if(!$month){
    //                 Toastr::error(__('cmn.please_select_month_first'), __('cmn.warning'));
    //                 return redirect()->back();
    //             }
    //             if($year){
    //                 $month_name = CommonService::getMonthNameByMonthId($month);
    //                 $data['title'] .= ' - (' . __('cmn.month') .'- ' .$month_name. ', ' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
                    
    //                 // deposit -----
    //                 $trips = $trips->whereYear('account_take_date',$year);

    //                 // expense -----
    //                 $expenses = $expenses->whereYear('date',$year); 
                
    //             } else {
    //                 $month_name = CommonService::getMonthNameByMonthId($month);
    //                 $data['title'] .= ' - (' . __('cmn.month') .'- ' .$month_name. ')';
                    
    //                 // deposit -----
    //                 $trips = $trips->whereMonth('account_take_date',$month);

    //                 // expense -----
    //                 $expenses = $expenses->whereMonth('date',$month);

    //             } 
    //         }
    //         // yearly report
    //         if($date_range_status == 'yearly_report'){
    //             if(!$year){
    //                 Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
    //                 return redirect()->back();
    //             }
    //             $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
                
    //             // deposit -----
    //             $trips = $trips->whereYear('account_take_date',$year);

    //             // expense -----
    //             $expenses = $expenses->whereYear('date',$year);
    //         }
    //     }
    //     if($vehicle_id){
    //         $vehicle = SettingVehicle::whereId($vehicle_id)->first();
    //         if(!$vehicle){
    //             Toastr::error(__('cmn.did_not_find_vehicle'),__('cmn.sorry'));
    //             return redirect()->back();
    //         }
    //         $data['title'] .=  ' (' . __('cmn.vehicle') .'-' . $vehicle->vehicle_number . ')';

    //         // deposit -----
    //         $trips = $trips->where('vehicle_id', $vehicle_id);
    //         // $due_collection = $due_collection->where('car_id', $request->car);
    //         // $capitals = $capitals->where('car_id', $request->car);


    //         // expense -----s
    //         $expenses = $expenses->where('vehicle_id', $vehicle_id);
    //         // $pro_expenses = $pro_expenses->where('car_id', $request->car);
    //         // $inst = Installment::where('car_id', $request->car)->first();
    //         // if(empty($inst)){
    //         //     $inst_history = [];
    //         // }else{
    //         //     $inst_history = $inst_history->where('install_id', $inst->id); 
    //         // }
    //         // process car number
    //         // $car_number = Vehicle::find($request->car);
    //         // $data['car_number'] = ($car_number)? $car_number->car_number : '';
    //     }
    //     // deposite
    //     $data['trips'] = $trips->groupBy('group_id')->get();
    //     $data['due_collection'] = [];
    //     // $data['due_collection'] = $due_collection->get();
    //     $data['capitals'] = [];

    //     // expense
    //     $data['expenses'] = $expenses->get();
    //     // $data['pro_expenses'] = $pro_expenses->get();
    //     // $data['inst_history'] = $inst_history;
    //     $data['pro_expenses'] = [];
    //     $data['inst_history'] = [];

    //     // return view('report.daily_accounts_report.daily_accounts_report', $data);
    //     // pdf
    //     $pdf = PDF::loadView('report.daily_accounts_report.daily_accounts_report_pdf',$data);
    //     // $pdf->setPaper('a4' , 'portrait');
    //     if($request->input('download_pdf') == 'true'){
    //         return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
    //     } else {
    //         return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
    //     }
    //     // return $pdf->output();
    // }

    public function firstFormat(Request $request){

        $data['reporting_time'] = date('d M, Y h:i:s a');
        $data['title'] = __('cmn.daily_accounts');
        $data['menu'] = 'all_report';
        $data['menu'] = 'daily_accounts'; 
        $data['car_number'] = null;
        $data['request'] = $request;

        // request assign
        $date_range_status = $request->input('date_range_status');
        $daterange = $request->input('daterange');
        $month = $request->input('month');
        $year = $request->input('year');

        // deposite part --------
        $single_challan_deposit = Trip::query()->where('type', 'own_vehicle_single');
        $up_down_challan_deposit = Trip::query()->where('type', 'own_vehicle_up_down');

        // $due_collection = DueCollection::orderBy('date','asc');
        // $capitals = Capital::orderBy('id', 'desc');

        // expense part --------
        $inside_challan_general_expense = Expense::query();
        $inside_challan_oil_expense = TripOilExpense::query();

        $outside_challan_general_expense = Expense::query();
        $outside_challan_oil_expense = TripOilExpense::query();

        // all time report
        if($date_range_status == 'all_time'){
            $data['title'] .= ' - ' . __('cmn.all_time');
        }

        // mothly report
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

            // deposit part -----
            $single_challan_deposit = $single_challan_deposit->whereMonth('date', $month)->whereYear('date',$year);
            $up_down_challan_deposit = $up_down_challan_deposit->whereMonth('date', $month)->whereYear('date',$year);

            // expense part -----
            $inside_challan_general_expense = $inside_challan_general_expense->whereMonth('date', $month)->whereYear('date',$year);
            $inside_challan_oil_expense = $inside_challan_oil_expense->whereMonth('date', $month)->whereYear('date',$year);

            $outside_challan_general_expense = $outside_challan_general_expense->whereMonth('date', $month)->whereYear('date',$year);
            $outside_challan_oil_expense = $outside_challan_oil_expense->whereMonth('date', $month)->whereYear('date',$year);
        }

        // yearly report
        if($date_range_status == 'yearly_report'){

            if(!$year){
                Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                return redirect()->back();
            }
            $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';

            // deposit part -----
            $single_challan_deposit = $single_challan_deposit->whereYear('date', $year);
            $single_challan_deposit = $single_challan_deposit->whereYear('date', $year);

            // expense part -----
            $inside_challan_general_expense = $inside_challan_general_expense->whereYear('date',$year);
            $inside_challan_oil_expense = $inside_challan_oil_expense->whereYear('date',$year);

            $outside_challan_general_expense = $outside_challan_general_expense->whereYear('date',$year);
            $outside_challan_oil_expense = $outside_challan_oil_expense->whereYear('date',$year);
        }

        // date wise
        if($date_range_status == 'date_wise' && $daterange){
            
            $date = explode(' - ', $daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
            
            // deposit part -----
            $single_challan_deposit = $single_challan_deposit->whereBetween('date', [$start_date, $end_date]);
            $up_down_challan_deposit = $up_down_challan_deposit->whereBetween('date', [$start_date, $end_date]);

            // expense part --------
            $inside_challan_general_expense = $inside_challan_general_expense->whereBetween('date', [$start_date, $end_date]);
            $inside_challan_oil_expense = $inside_challan_oil_expense->whereBetween('date', [$start_date, $end_date]);

            $outside_challan_general_expense = $outside_challan_general_expense->whereBetween('date', [$start_date, $end_date]);
            $outside_challan_oil_expense = $outside_challan_oil_expense->whereBetween('date', [$start_date, $end_date]);
        }

        // deposite part --------
        $data['single_challan_deposit'] = $single_challan_deposit->get()->sum('company.advance_fair') + $single_challan_deposit->get()->sum('company.received_fair');
        $data['up_down_challan_deposit'] = $up_down_challan_deposit->get()->sum('company.advance_fair') + $up_down_challan_deposit->get()->sum('company.received_fair');

        // expense part --------
        $data['inside_challan_general_expense'] = $inside_challan_general_expense->whereNotNull('trip_id')->get()->sum('amount');
        $data['outside_challan_general_expense'] = $outside_challan_general_expense->whereNull('trip_id')->get()->sum('amount');

        $data['inside_challan_oil_expense'] = $inside_challan_oil_expense->whereNotNull('trip_id')->get()->sum('bill');
        $data['outside_challan_oil_expense'] = $outside_challan_oil_expense->whereNull('trip_id')->get()->sum('bill');

        // pdf generate
        $pdf = PDF::loadView('report.daily_accounts_report.page.first_format',$data);

        // $pdf->setPaper('a4' , 'portrait');
        if($request->input('download_pdf') == 'true'){
            return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        } else {
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }
        // return $pdf->output();
    }



}