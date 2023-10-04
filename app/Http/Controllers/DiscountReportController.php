<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Trip;
use App\Vehicle;
use App\Client;

use DB;
use Auth;
use Toastr;
use Carbon\Carbon;

class DiscountReportController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function discount_report_form(Request $request){
        $data['title'] = 'Discount Report Form';
        $data['menu'] = 'report';
        $data['sub_menu'] = 'discount_report';
        $data['request'] = $request;
        $data['cars'] = Vehicle::all();
        $data['clients'] = Client::all();
        return view('discount.discount_report_form', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function discount_report (Request $request)
    {

        $data['menu'] = 'report';
        $data['menu'] = 'discount_report';
        $data['title'] = 'Discount Report';
        $data['request'] = $request;
        $data['clients'] = Client::all();

        $discount_data = Trip::orderBy('trip_date','asc');
        if ($request->has('date') && $request->date == 1 && $request->daterange) {
            $date = explode(' - ',$request->daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y') .' to '. Carbon::parse($date[1])->format('d M, Y');
            $discount_data = $discount_data->whereBetween('trip_date', [$start_date, $end_date]);
        }

        if(empty($request->car) && empty($request->client)){
            $data['discount_data'] = $discount_data->get();
            return view('discount.discount_report', $data);
        }else{
            if($request->client){
                $discount_data = $discount_data->where('trip_client_id', $request->client);
                $data['client_name'] = Client::find($request->client)->client_name;
            }
            if($request->car){
                $discount_data = $discount_data->where('trip_car_id', $request->car);
                $data['car_number'] = Vehicle::find($request->car)->car_number;
            }
            
        }

        $data['discount_data'] = $discount_data->get();
        return view('discount.discount_report_client_vehicle_wise', $data);

    }
}
