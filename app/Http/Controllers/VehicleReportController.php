<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Vehicle;
use App\CarTotalProjectExpense;

// use App\CarType;
// use App\People;
// use App\Designation;

use DB;
use Auth;
use Toastr;

class VehicleReportController extends Controller
{
    /**
     * construct of this class
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function vehicle_report_form(Request $request){
        $data['title'] = 'Vehicle Report Form';
        $data['menu'] = 'report';
        $data['sub_menu'] = 'vehicle_report';
        $data['request'] = $request;
        $data['cars'] = Vehicle::all();
        return view('vehicle.vehicle_report_form', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function vehicle_ledger_report(Request $request)
    {
        // dd($request);
        // "daterange" => "09/13/2020 - 09/13/2020"
        // "car" => "3"
        // "report_type" => "total_project"
        // date range
        // type condition



        if(Vehicle::where('car_id',$request->car)->exists()){
            if($request->report_type == 'total_project'){
                $data['car_total_project_exps'] = CarTotalProjectExpense::join('project_expenses','car_total_project_expenses.project_exp_id','=','project_expenses.project_exp_id')
                                                ->where('car_id', $request->car)
                                                ->select('project_expenses.project_exp_head','car_total_project_expenses.*')
                                                ->get();
                $data['menu'] = 'report';
                $data['menu'] = 'vehicl_report';
                $data['title'] = hybrid_first('cars','car_id',$request->car,'car_number') . ' গাড়ীর মোট প্রকল্প হিসাব রিপোর্ট';
                return view('vehicle.report.vehicle_ledger_report', $data);
            }
        }else{
            Toastr::error('খুঁজে পাওয়া যায়নি!', 'দুঃখিত');
            return redirect()->back();
        }
    }
    
}