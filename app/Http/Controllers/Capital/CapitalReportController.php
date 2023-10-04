<?php

namespace App\Http\Controllers\Capital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CapitalHistory;
use App\Models\Capital;
use App\Models\Investor;
use App\Vehicle;
use Toastr;
use Auth;
use DB;

class CapitalReportController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function capital_report_filter(Request $request){
        $data['title'] = 'Capital Report Form';
        $data['menu'] = 'report';
        $data['sub_menu'] = 'capital_report';
        $data['request'] = $request;
        $data['cars'] = Vehicle::all();
        $data['investors'] = Investor::orderBy('sort','asc')->get();
        return view('capitals.capital_report_form', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function installment_general_report(Request $request)
    {
        $data['title'] = 'Installment General Report';
        $data['menu'] = 'installment_report';
        $data['request'] = $request;
        $data['cars'] = Vehicle::with('installment')->find($request->car);

        if(empty($data['cars']->installment)){
        	Toastr::error('','No Installment found for this car');
        	return redirect()->back();
        }
        $installment_history = InstallmentHistory::where('install_id', $data['cars']->installment->id);

        if ($request->has('date') && $request->date == 1 && $request->daterange) {
            $date = explode(' - ',$request->daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y') .' to '. Carbon::parse($date[1])->format('d M, Y');
            $installment_history = $installment_history->whereBetween('pay_date', [$start_date, $end_date]);
        }
        // if ($request->daterange) {
        //     $date = explode(' - ',$request->daterange);
        //     $start_date = Carbon::parse($date[0])->format('Y-m-d');
        //     $end_date = Carbon::parse($date[1])->format('Y-m-d');
        //     $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y') .' - '. Carbon::parse($date[1])->format('d M, Y');
        //   	$installment_history = $installment_history->whereBetween('pay_date', [$start_date, $end_date]);
        // }
        if(count($installment_history->get()) > 0){
        	$data['installment_history'] = $installment_history->get();
        }else{
        	Toastr::error('','Not Installment found');
        	return redirect()->back();
        }
        return view('installment.report.installment_report', $data);
    }
}
