<?php

namespace App\Http\Controllers\Due;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Trip;
use App\Vehicle;
use App\Client;
use App\Due;
use App\DueCollection;

use DB;
use Auth;
use Toastr;
use Carbon\Carbon;

class DueReportController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function due_report_form(Request $request){
        $data['title'] = 'Due Report Form';
        $data['menu'] = 'report';
        $data['sub_menu'] = 'due_report';
        $data['request'] = $request;
        $data['cars'] = Vehicle::all();
        $data['clients'] = Client::all();
        return view('due.due_report_form', $data);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function due_report (Request $request)
    {
        $data['menu'] = 'report';
        $data['sub_menu'] = 'due_report';
        $data['request'] = $request;
        $data['title'] = 'Due Report';
        $data['clients'] = Client::all();

        $due_data = Trip::orderBy('trip_date','asc')->where('trip_due_fair', '>' ,0);
        if ($request->has('date') && $request->date == 1 && $request->daterange) {
            $date = explode(' - ',$request->daterange);
            $data['start_date'] = Carbon::parse($date[0])->startOfDay();
            $data['end_date'] = Carbon::parse($date[1])->endOfDay();
            $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y') .' to '. Carbon::parse($date[1])->format('d M, Y');
            $due_data = $due_data->whereBetween('trip_date', [$data['start_date'], $data['end_date']]);
        }
        if(empty($request->car) && empty($request->client)){
            return view('due.due_report', $data);
        }else{
            if($request->client){
                $due_data = $due_data->where('trip_client_id', $request->client);
                $data['client_name'] = Client::find($request->client)->client_name;
            }
            if($request->car){
                $due_data = $due_data->where('trip_car_id', $request->car);
                $data['car_number'] = Vehicle::find($request->car)->car_number;
            }
        }
        $data['due_data'] = $due_data->get();
        return view('due.due_report_client_vehicle_wise', $data);
    }

    public function paid_due_report(Request $request){
        $data['menu'] = 'report';
        $data['sub_menu'] = 'paid_due_report';
        $data['request'] = $request;
        $data['title'] = 'Paid Due Report';
        $data['client'] = Client::find($request->client);
        
        $due_data = DueCollection::orderBy('date','asc');
        if ($request->has('date') && $request->date == 1 && $request->daterange) {
            $date = explode(' - ',$request->daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y') .' to '. Carbon::parse($date[1])->format('d M, Y');
            $due_data = $due_data->whereBetween('date', [$start_date, $end_date]);
        }
        if($request->client){
            $due_data = $due_data->where('client_id', $request->client);
        }

        $data['due_data'] = $due_data->get();
        return view('due.paid_due_report', $data);
    }

    public function due_history_report(Request $request){
        $data['menu'] = 'report';
        $data['sub_menu'] = 'due_report';
        $data['request'] = $request;
        $data['title'] = 'Due History Report';
        $data['clients'] = Client::all();

        $due_data = Due::orderBy('date','asc');
        if ($request->has('date') && $request->date == 1 && $request->daterange) {
            $date = explode(' - ',$request->daterange);
            $data['start_date'] = Carbon::parse($date[0])->startOfDay();
            $data['end_date'] = Carbon::parse($date[1])->endOfDay();
            $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y') .' to '. Carbon::parse($date[1])->format('d M, Y');
            $due_data = $due_data->whereBetween('date', [$data['start_date'], $data['end_date']]);
        }
        if(empty($request->car) && empty($request->client)){
            return view('due.due_history_report', $data);
        }else{
            if($request->client){
                $due_data = $due_data->where('client_id', $request->client);
                $data['client_name'] = Client::find($request->client)->client_name;
            }
            if($request->car){
                $trips_data = Trip::where('trip_car_id', $request->car)->get()->toArray();
                $ids = array_column($trips_data, 'trip_id');
                $due_data = $due_data->whereIn('table_id', array_unique($ids))->where('table_name', 'trips');
                $data['car_number'] = Vehicle::find($request->car)->car_number;
            }
        }
        $data['due_data'] = $due_data->get();
        return view('due.due_history_report_client_vehicle_wise', $data);
    }

    //clinet_wise_paid_due_report
    public function clinet_wise_paid_due_report(Request $request){
        $data['clients'] = Client::findOrFail($request->client);
        $data['menu'] = 'report';
        $data['sub_menu'] = 'clinet_wise_paid_due_report';
        $data['request'] = $request;
        $data['title'] = 'Client wise paid due Report';
        $due_data = Due::orderBy('date','asc')->where('client_id', $request->client);
        $due_collection = DueCollection::orderBy('date','asc')->where('client_id', $request->client);
        if ($request->has('date') && $request->date == 1 && $request->daterange) {
            $date = explode(' - ',$request->daterange);
            $data['start_date'] = Carbon::parse($date[0])->startOfDay();
            $data['end_date'] = Carbon::parse($date[1])->endOfDay();
            $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y') .' to '. Carbon::parse($date[1])->format('d M, Y');
            $due_collection = $due_collection->whereBetween('date', [$data['start_date'], $data['end_date']]);
            $due_data = $due_data->whereBetween('date', [$data['start_date'], $data['end_date']]);
        }
        $data['due_collection'] = $due_collection->get();
        $data['due_data'] = $due_data->get();
        return view('due.clinet_wise_paid_due_report', $data);
    }
}
