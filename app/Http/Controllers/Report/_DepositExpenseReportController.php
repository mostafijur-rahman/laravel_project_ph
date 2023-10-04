<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Vehicle;
use App\CarTotalProjectExpense;
use App\ProjectExpense;
use App\CommonExpense;

use DB;
use Auth;
use Toastr;
use Carbon\Carbon;

class DepositExpenseReportController extends Controller
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
    public function deposit_expense_report_form(Request $request){
        $data['title'] = 'Deposit Expense Report Form';
        $data['menu'] = 'report';
        $data['sub_menu'] = 'deposit_expense';
        $data['request'] = $request;
        $data['cars'] = [];
        return view('report.deposit_expense_report_form', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function deposit_expense_report(Request $request)
    {
        $data['title'] = 'vehicl_report';
        $data['menu'] = 'report';
        $data['menu'] = 'vehicl_report';
        // $data['project_expenses'] = ProjectExpense::orderBy('project_exp_sort','asc')->get();
        // $data['common_expenses'] = CommonExpense::orderBy('exp_sort','asc')->get();
        $data['request'] = $request;
        // if ($request->has('date') && $request->date == 1 && $request->daterange) {
        if ($request->daterange) {
            $date = explode(' - ',$request->daterange);
            // single date
            if($date[0] == $date[1]){
                $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y');
            }else{
            // date range
                $start_date = Carbon::parse($date[0])->startOfDay();
                $end_date = Carbon::parse($date[1])->endOfDay();
                $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y') .' - '. Carbon::parse($date[1])->format('d M, Y');
            }
        }
        return view('report.deposit_expense_report', $data);
    }
    
    

}