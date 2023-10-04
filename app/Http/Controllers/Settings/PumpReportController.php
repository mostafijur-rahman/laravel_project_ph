<?php

namespace App\Http\Controllers\Pump;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Car;
use App\Route;
use App\Trip;
use App\TimeSheet;
use App\People;

use App\TripDetails;
use App\CounterBooking;
use App\TripExpenses;
use App\Expense;
use App\Counter;
use App\CommonExpense;

use DB;
use PDF;
use Toastr;
use Auth;
use Carbon\Carbon;

class PumpReportController extends Controller {
    /**
     * construct of this class
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * route wise booking counter report list form
     */
    function pump_report_form(Request $request){
        $data['title'] = 'Pump Report';
        $data['request'] = $request;
        $data['menu'] = 'report';
        $data['sub_menu'] = 'pump_report';
        $data['pumps'] = Db::Table('pumps')->get();
        $data['cars'] = Db::Table('cars')->get();
        $data['drivers'] = Db::Table('people')
                            ->where('people_desig_id',2)
                            ->orderBy('people_sort','asc')
                            ->get();
        return view('pump.pump_report_form', $data);
    }
    /**
     * route wise booking counter report list report
     */
    function pump_general_report(Request $request){
        $query = Db::Table('trip_oil_expenses')
                    ->leftjoin('trips','trip_oil_expenses.trip_id','=','trips.trip_id')
                    ->leftjoin('pumps','trip_oil_expenses.pump_id','=','pumps.pump_id')
                    ->leftjoin('people','trip_oil_expenses.driver_id','=','people.people_id');
        // where
        if ($request->has('date') && $request->date == 1 && $request->daterange) {
            $date = explode(' - ',$request->daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y') .' to '. Carbon::parse($date[1])->format('d M, Y');
            $query = $query->whereBetween('trips.trip_date', [$start_date, $end_date]);
        }
        if($request->pump){
            $query = $query->where('trip_oil_expenses.pump_id', $request->pump);
            if( Db::Table('pumps')->where('pump_id',$request->pump)->exists()){
                $pump_name = Db::Table('pumps')->where('pump_id',$request->pump)->select('pump_name')->first();
            }
        }
        if($request->trip_number){
            $query = $query->where('trip_oil_expenses.trip_no', $request->trip_number);
        }
        if($request->car){
            $query = $query->leftjoin('cars','trip_oil_expenses.car_id','=','cars.car_id');
            $query = $query->where('trip_oil_expenses.car_id', $request->car);
            if(Db::Table('cars')->where('car_id',$request->car)->exists()){
                $car_number = Db::Table('cars')->where('car_id', $request->car)->select('car_number')->first();
            }
        }
        if($request->people){
            $query = $query->where('trip_oil_expenses.driver_id', $request->people);
            if(Db::Table('people')->where('people_id',$request->people)->exists()){
                $people_name = Db::Table('people')->where('people_id', $request->people)->select('people_name')->first();
            }
        }
        $data['oil_exps'] = $query->select('trips.trip_date',
                                            'pumps.pump_name',
                                            'trip_oil_expenses.trip_no',
                                            'trip_oil_expenses.car_number',
                                            'people.people_name',
                                            'trip_oil_expenses.trip_oil_exp_liter',
                                            'trip_oil_expenses.trip_oil_exp_rate',
                                            'trip_oil_expenses.trip_oil_exp_bill')
                                ->orderBy('trips.trip_date','desc')
                                ->get();
        $data['menu'] = 'report';
        $data['request'] = $request;
        $data['title'] = ($request->pump)?'Pump: '.$pump_name->pump_name:'Pump Report';
        if($request->car){
            $data['title'] .= ', Vehicle: '.$car_number->car_number;
        }
        if($request->people){
            $data['title'] .= ', Driver: '.$people_name->people_name;
        }
        if($request->trip_number){
            $data['title'] .= ', Trip Number: '.$request->trip_number;
        }
        return view('pump.report.pump_general_report', $data);
    }
    /**
     * route wise booking counter report list report
     */
    function pump_monthly_yearly_report(Request $request){
        $query = Db::Table('trip_oil_expenses')
                    ->leftjoin('trips','trip_oil_expenses.trip_id','=','trips.trip_id')
                    ->leftjoin('pumps','trip_oil_expenses.pump_id','=','pumps.pump_id')
                    ->leftjoin('people','trip_oil_expenses.driver_id','=','people.people_id');
        // where
        // if ($request->has('date') && $request->date == 1 && $request->daterange) {
        //     $date = explode(' - ',$request->daterange);
        //     $start_date = Carbon::parse($date[0])->startOfDay();
        //     $end_date = Carbon::parse($date[1])->endOfDay();
        //     $data['date_show'] =  Carbon::parse($date[0])->format('d M, Y') .' to '. Carbon::parse($date[1])->format('d M, Y');
        //     $query = $query->whereBetween('trips.trip_date', [$start_date, $end_date]);
        // }
        if($request->month){
            $query = $query->whereMonth('trips.trip_date', $request->month);
        }
        if($request->year){
            $query = $query->whereYear('trips.trip_date', $request->year);
        }
        if($request->pump){
            $query = $query->where('trip_oil_expenses.pump_id', $request->pump);
            if( Db::Table('pumps')->where('pump_id',$request->pump)->exists()){
                $pump_name = Db::Table('pumps')->where('pump_id',$request->pump)->select('pump_name')->first();
            }
        }
        if($request->car){
            $query = $query->leftjoin('cars','trip_oil_expenses.car_id','=','cars.car_id');
            $query = $query->where('trip_oil_expenses.car_id', $request->car);
            if(Db::Table('cars')->where('car_id',$request->car)->exists()){
                $car_number = Db::Table('cars')->where('car_id', $request->car)->select('car_number')->first();
            }
        }
        if($request->people){
            $query = $query->where('trip_oil_expenses.driver_id', $request->people);
            if(Db::Table('people')->where('people_id',$request->people)->exists()){
                $people_name = Db::Table('people')->where('people_id', $request->people)->select('people_name')->first();
            }
        }
        $data['oil_exps'] = $query->select('trips.trip_date',
                                            'pumps.pump_name',
                                            'trip_oil_expenses.trip_no',
                                            'trip_oil_expenses.car_number',
                                            'people.people_name',
                                            'trip_oil_expenses.trip_oil_exp_liter',
                                            'trip_oil_expenses.trip_oil_exp_rate',
                                            'trip_oil_expenses.trip_oil_exp_bill')
                                ->orderBy('trips.trip_date','desc')
                                ->get();
        $data['menu'] = 'report';
        $data['request'] = $request;
        $data['title'] = ($request->pump)?'Pump: '.$pump_name->pump_name:'Pump Report';
        if($request->month){
            $data['title'] .= ', Month: '. date("F", mktime(0, 0, 0, $request->month, 10));
        }
        if($request->year){
            $data['title'] .= ', Year: '. $request->year;
        }
        if($request->car){
            $data['title'] .= ', Vehicle: '.$car_number->car_number;
        }
        if($request->people){
            $data['title'] .= ', Driver: '.$people_name->people_name;
        }
        return view('pump.report.pump_monthly_yearly_report', $data);
    }
}