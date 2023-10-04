<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\User;
use App\Models\Trips\Trip;
use App\Models\Expenses\Expense;
use App\Models\Trips\TripOilExpense;
use App\Models\Trips\TripDemarage;

use Auth;
use Toastr;
use Carbon\Carbon;
use DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        switch ($request->input('dashboard')) {
            case 'one':
                return $this->dashboardOne($request);
                break;
            
            case 'two':
                return $this->dashboardTwo($request);
                break;

            default:
                return $this->dashboardTwo($request);
                break;
        }

    }

    public function vehicle_tracking()
    {
        $data['title'] = __('cmn.vehicle_tracking');
        $data['top_title'] = __('cmn.vehicle_tracking');
        $data['menu'] = 'vehicle_tracking';
        return view('vehicle_tracking', $data);
    }

    public function help()
    {
        $data['title'] = 'Help';
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'help';
        return view('help', $data);
    }

    public function profile()
    {
        $data['title'] = 'Profile';
        $data['menu'] = 'profile';
        $data['sub_menu'] = 'profile';
        $data['nav_link'] = 'personal_info';
        return view('profile', $data);
    }

    /**
     * Display a listing of the resource.
     * User Profile Update
     * @return \Illuminate\Http\Request
     */
    public function profile_update(Request $request)
    {
        if(User::where('email', $request->email)->skip(Auth::user()->id)->first()){
            Toastr::error('Error', 'Email Has Already Taken');
            return redirect()->back();
        }
        $data = Auth::user();
        $data->first_name = $request->first_name;
        $data->last_name = $request->last_name;
        $data->email = $request->email;
        try {
            $data->save();
        } catch (Exception $e) {
            Toastr::error('Error', $e->message());
            return redirect()->back();
        }
        Toastr::success('Success','Successfully Update your info');
        return redirect()->back();
    }

    public function change_password(Request $request)
    {
        $data =  Auth::user();
        if(!(Hash::check($request->old_password, $data->password))){
            Toastr::error('Error', 'Old password not match');
            return redirect()->back();
        }
        if($request->new_password != $request->confirm_password){
            Toastr::error('Error', 'Confirm password not match');
            return redirect()->back();
        }
        //assign new password
        $data->password = Hash::make($request->new_password);
        try {
            $data->save();
        } catch (Exception $e) {
            Toastr::error('Error', $e->message());
            return redirect()->back();
        }

        Toastr::success('Success','Successfully Chnage Password');
        return redirect()->back();
    }

    public function cashMemoryClear()
    {
        try{
            \Artisan::call('optimize:clear');
            Toastr::success('',__('cmn.cash_memory_cleared_successfully'));
            return redirect()->back();
        }
        catch(\Exception $e){
            Toastr::error('Error', $e->message());
            return redirect()->back();
        }
    }
    
    public function  dashboardOne($request){

        $data['title'] = __('cmn.dashboard');
        $data['top_title'] = __('cmn.dashboard');
        $data['menu'] = 'dashboard';
        $data['sub_menu'] = 'one';
        
        $time_range = $request->has('time_range')?$request->input('time_range'):'today';
        $data['request'] = $request;
        $data['title'] = '';
        $data['display'] = 'none';

        // query start from here
        $query = Trip::query()->with('provider','company');

        $single_challan_deposit = Trip::query()->where('type', 'own_vehicle_single');
        $single_challan_due = Trip::query()->where('type', 'own_vehicle_single');

        $up_down_challan_deposit = Trip::query()->where('type', 'own_vehicle_up_down');
        $up_down_challan_due = Trip::query()->where('type', 'own_vehicle_up_down');

        $inside_challan_general_expense = Expense::query();
        $inside_challan_oil_expense = TripOilExpense::query();

        $outside_challan_general_expense = Expense::query();
        $outside_challan_oil_expense = TripOilExpense::query();

        switch ($time_range) {
            case 'today':
                $start = Carbon::now()->startOfDay();
                $end = Carbon::now()->endOfDay();
                $data['title'] = Carbon::now()->startOfDay()->format('d F, Y');
                break;

            case 'yesterday':
                $start = Carbon::yesterday()->startOfDay();
                $end = Carbon::yesterday()->endOfDay();
                $data['title'] = Carbon::yesterday()->startOfDay()->format('d F, Y');
                break;

            case 'last_one_week':
                $start = Carbon::now()->subDays(7)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $data['title'] = Carbon::now()->subDays(7)->startOfDay()->format('d F, Y') .' ' . __('cmn.from') . ' ' . Carbon::now()->endOfDay()->format('d F, Y');
                break;

            case 'last_fifteen_days':
                    $start = Carbon::now()->subDays(15)->startOfDay();
                    $end = Carbon::now()->endOfDay();
                    $data['title'] = Carbon::now()->subDays(15)->startOfDay()->format('d F, Y') .' ' . __('cmn.from') . ' ' . Carbon::now()->endOfDay()->format('d F, Y');
                    break;

            case 'last_thirty_days':
                $start = Carbon::now()->subDays(30)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $data['title'] = Carbon::now()->subDays(30)->startOfDay()->format('d F, Y') .' ' . __('cmn.from') . ' ' . Carbon::now()->endOfDay()->format('d F, Y');
                break;

            case 'last_ninety_days':
                $start = Carbon::now()->subDays(90)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $data['title'] = Carbon::now()->subDays(90)->startOfDay()->format('d F, Y') .' ' . __('cmn.from') . ' ' . Carbon::now()->endOfDay()->format('d F, Y');
                break;

            case 'all_time':
                $data['title'] = __('cmn.all_time');
                break;

            case 'date_wise':
                $daterange = $request->input('daterange');
                $date = explode(' - ', $daterange);
                $start = Carbon::parse($date[0])->startOfDay();
                $end = Carbon::parse($date[1])->endOfDay();
                $data['title'] = __('cmn.date_wise') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
                $data['display'] = 'block';
                break;

            default:
                $start = Carbon::now()->startOfDay();
                $end = Carbon::now()->endOfDay();
        }

        if($time_range != 'all_time'){
            $query = $query->whereBetween('date', [$start, $end]);

            $single_challan_deposit = $single_challan_deposit->whereBetween('date', [$start, $end]);
            $single_challan_due = $single_challan_due->whereBetween('date', [$start, $end]);

            $up_down_challan_deposit = $up_down_challan_deposit->whereBetween('date', [$start, $end]);
            $up_down_challan_due = $up_down_challan_due->whereBetween('date', [$start, $end]);

            $inside_challan_general_expense = $inside_challan_general_expense->whereBetween('date', [$start, $end]);
            $inside_challan_oil_expense = $inside_challan_oil_expense->whereBetween('date', [$start, $end]);

            $outside_challan_general_expense = $outside_challan_general_expense->whereBetween('date', [$start, $end]);
            $outside_challan_oil_expense = $outside_challan_oil_expense->whereBetween('date', [$start, $end]);
        }
    
        $data['challan_qty'] = $query->get()->count();

        $data['received_from_company'] = $query->get()->sum('company.advance_fair') + $query->get()->sum('company.received_fair');
        $data['due_bill_of_company'] = $query->get()->sum('company.due_fair');

        $data['paid_bill_to_provider'] = $query->get()->sum('provider.advance_fair') + $query->get()->sum('provider.received_fair');
        $data['due_bill_of_provider'] = $query->get()->sum('provider.due_fair');

        $data['sum_deposit_of_own_challan'] = $query->whereHas('provider', function($q){
                                                    $q->where('ownership', '=', 'own');
                                                })->get()->sum('provider.advance_fair');

                                                + $query->whereHas('provider', function($q){
                                                    $q->where('ownership', '=', 'own');
                                                })->get()->sum('provider.received_fair');
                                                
        // challan section
        $data['single_challan_deposit'] = $single_challan_deposit->get()->sum('company.advance_fair') + $single_challan_deposit->get()->sum('company.received_fair');
        $data['single_challan_due'] = $single_challan_due->get()->sum('company.due_fair');
        
        $data['up_down_challan_deposit'] = $up_down_challan_deposit->get()->sum('company.advance_fair') + $up_down_challan_deposit->get()->sum('company.received_fair');
        $data['up_down_challan_due'] = $up_down_challan_due->get()->sum('company.due_fair');
        
        $data['total_challan_deposit'] = $data['single_challan_deposit'] + $data['up_down_challan_deposit'];
        $data['total_challan_due'] = $data['single_challan_due'] + $data['up_down_challan_due'];

        // expense section
        $data['inside_challan_general_expense'] = $inside_challan_general_expense->whereNotNull('trip_id')->get()->sum('amount');
        $data['outside_challan_general_expense'] = $outside_challan_general_expense->whereNull('trip_id')->get()->sum('amount');
        $data['total_general_expense'] = $data['inside_challan_general_expense'] + $data['outside_challan_general_expense'];

        $data['inside_challan_oil_expense'] = $inside_challan_oil_expense->whereNotNull('trip_id')->get()->sum('bill');
        $data['outside_challan_oil_expense'] = $outside_challan_oil_expense->whereNull('trip_id')->get()->sum('bill');
        $data['total_oil_expense'] = $data['inside_challan_oil_expense'] + $data['outside_challan_oil_expense'];

        $data['total_expense'] = $data['inside_challan_general_expense']+$data['inside_challan_oil_expense']+$data['outside_challan_general_expense']+$data['outside_challan_oil_expense'];
        
        $data['balance'] = $data['total_challan_deposit']-$data['total_expense'];

        return view('dashboard_one', $data);
    }

    public function  dashboardTwo($request){

        $data['title'] = __('cmn.dashboard');
        $data['top_title'] = __('cmn.dashboard');
        $data['menu'] = 'dashboard';
        $data['sub_menu'] = 'two';

        $time_range = $request->has('time_range')?$request->input('time_range'):'today';
        $data['request'] = $request;
        $data['title'] = '';
        $data['display'] = 'none';

        // query for single challan
        $single_challan = Trip::query()->where('type', 'own_vehicle_single');

        // query for up down challan
        $up_down_challan = Trip::query()->where('type', 'own_vehicle_up_down');

        // outside of trip query
        $outside_general_expense_of_trip = Expense::query();
        $outside_oil_expense_of_trip = TripOilExpense::query();

        switch ($time_range) {
            case 'today':
                $start = Carbon::now()->startOfDay();
                $end = Carbon::now()->endOfDay();
                $data['title'] = Carbon::now()->startOfDay()->format('d F, Y');
                break;

            case 'yesterday':
                $start = Carbon::yesterday()->startOfDay();
                $end = Carbon::yesterday()->endOfDay();
                $data['title'] = Carbon::yesterday()->startOfDay()->format('d F, Y');
                break;

            case 'last_one_week':
                $start = Carbon::now()->subDays(7)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $data['title'] = Carbon::now()->subDays(7)->startOfDay()->format('d F, Y') .' ' . __('cmn.from') . ' ' . Carbon::now()->endOfDay()->format('d F, Y');
                break;

            case 'last_fifteen_days':
                    $start = Carbon::now()->subDays(15)->startOfDay();
                    $end = Carbon::now()->endOfDay();
                    $data['title'] = Carbon::now()->subDays(15)->startOfDay()->format('d F, Y') .' ' . __('cmn.from') . ' ' . Carbon::now()->endOfDay()->format('d F, Y');
                    break;

            case 'last_thirty_days':
                $start = Carbon::now()->subDays(30)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $data['title'] = Carbon::now()->subDays(30)->startOfDay()->format('d F, Y') .' ' . __('cmn.from') . ' ' . Carbon::now()->endOfDay()->format('d F, Y');
                break;

            case 'last_ninety_days':
                $start = Carbon::now()->subDays(90)->startOfDay();
                $end = Carbon::now()->endOfDay();
                $data['title'] = Carbon::now()->subDays(90)->startOfDay()->format('d F, Y') .' ' . __('cmn.from') . ' ' . Carbon::now()->endOfDay()->format('d F, Y');
                break;

            case 'all_time':
                $data['title'] = __('cmn.all_time');
                break;

            case 'date_wise':
                $daterange = $request->input('daterange');
                $date = explode(' - ', $daterange);
                $start = Carbon::parse($date[0])->startOfDay();
                $end = Carbon::parse($date[1])->endOfDay();
                $data['title'] = __('cmn.date_wise') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
                $data['display'] = 'block';
                break;

            default:
                $start = Carbon::now()->startOfDay();
                $end = Carbon::now()->endOfDay();
        }

        if($time_range != 'all_time'){

            // single challan query
            $single_challan = $single_challan->whereBetween('date', [$start, $end]);

            // up down challan query
            $up_down_challan = $up_down_challan->whereBetween('date', [$start, $end]);

            // outside of trip query
            $outside_general_expense_of_trip = $outside_general_expense_of_trip->whereBetween('date', [$start, $end]);
            $outside_oil_expense_of_trip = $outside_oil_expense_of_trip->whereBetween('date', [$start, $end]);
        }

        // Sales chart section -----------------------------------------------------------------------------------------------
        // by default reset sales chart
        $data['final_deposit_sums'] = ['0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];
        $data['final_expense_sums'] = ['0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];
        $data['final_due_sums'] = ['0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0'];

        $monthly_deposit_sums = Trip::whereYear('date', '2023')->get()->groupBy(function ($item) {
                    return Carbon::parse($item->date)->month;
                })->map(function ($item) {
                    return $item->sum('company.advance_fair') + $item->sum('company.received_fair');
                })->toArray();


        $monthly_expense_sums = Expense::whereYear('date', '2023')->get()->groupBy(function ($item) {
                    return Carbon::parse($item->date)->month;
                })->map(function ($item) {
                    return $item->sum('amount');
                })->toArray();

        $monthly_due_sums = Trip::whereYear('date', '2023')->get()->groupBy(function ($item) {
                    return Carbon::parse($item->date)->month;
                })->map(function ($item) {
                    return $item->sum('company.due_fair');
                })->toArray();


        $final_deposit_sums = [];
        $final_expense_sums = [];
        $final_due_sums = [];

        for ($month = 1; $month <= 12; $month++) {

            // deposit
            if(count($monthly_deposit_sums) > 0){
                $final_deposit_sums[] = array_key_exists($month, $monthly_deposit_sums)?$monthly_deposit_sums[$month]:0;
            }

            // expense
            if(count($monthly_expense_sums) > 0){
                $final_expense_sums[] = array_key_exists($month, $monthly_expense_sums)?$monthly_expense_sums[$month]:0;
            }

            // due
            if(count($monthly_due_sums) > 0){
                $final_due_sums[] = array_key_exists($month, $monthly_due_sums)?$monthly_due_sums[$month]:0;
            }

        }

        $data['final_deposit_sums'] = $final_deposit_sums;
        $data['final_expense_sums'] = $final_expense_sums;
        $data['final_due_sums'] = $final_due_sums;
        $data['sales_labels'] = [__('cmn.january'), __('cmn.february'), __('cmn.march'), __('cmn.april'), __('cmn.may'), __('cmn.june'), __('cmn.july'), __('cmn.august'), __('cmn.september'), __('cmn.october'), __('cmn.november'), __('cmn.december')];


        // single challan section -----------------------------------------------------------------------------------------------
        $single_challan_ids =  $single_challan->pluck('id')->toArray();
    
        $data['single_challan_qty'] = count($single_challan_ids);

        $data['single_challan_contract_rent'] = $single_challan->get()->sum('company.contract_fair');
        $data['single_advance_received'] = $single_challan->get()->sum('company.advance_fair');
        $data['single_after_advance'] = $single_challan->get()->sum('company.received_fair');
        $data['single_challan_due'] = $single_challan->get()->sum('company.due_fair');

        $data['single_demurrage_received'] = (count($single_challan_ids)>0)?TripDemarage::whereIn('trip_id', $single_challan_ids)->sum('company_amount'):0;

        $data['single_challan_deposit'] = $data['single_advance_received'] + $data['single_after_advance'] + $data['single_demurrage_received'];
        $data['single_challan_expense'] = (count($single_challan_ids)>0)?Expense::whereIn('trip_id', $single_challan_ids)->sum('amount'):0;
        $data['single_challan_oil_expense'] = (count($single_challan_ids)>0)?TripOilExpense::whereIn('trip_id', $single_challan_ids)->sum('bill'):0;
        $data['single_challan_balance'] = $data['single_challan_deposit'] - ($data['single_challan_expense'] + $data['single_challan_oil_expense']);

        $data['single_challan_liter'] = (count($single_challan_ids)>0)?TripOilExpense::whereIn('trip_id', $single_challan_ids)->sum('liter'):0;
        $data['single_challan_distance'] = $single_challan->get()->sum('meter.current_reading') - $single_challan->get()->sum('meter.previous_reading');
        if($data['single_challan_distance'] > 0 &&  $data['single_challan_liter'] > 0){
            $data['single_challan_mileage'] = $data['single_challan_distance'] / $data['single_challan_liter'];
        } else {
            $data['single_challan_mileage'] = 0;
        }
        
        // up down challan section -----------------------------------------------------------------------------------------------
        $up_down_challan_ids =  $up_down_challan->pluck('id')->toArray();
        
        $data['up_down_challan_qty'] = count($up_down_challan_ids);

        $data['up_down_challan_contract_rent'] = $up_down_challan->get()->sum('company.contract_fair');
        $data['up_down_advance_received'] = $up_down_challan->get()->sum('company.advance_fair');
        $data['up_down_after_advance'] = $up_down_challan->get()->sum('company.received_fair');
        $data['up_down_challan_due'] = $up_down_challan->get()->sum('company.due_fair');

        $data['up_down_demurrage_received'] = (count($up_down_challan_ids)>0)?TripDemarage::whereIn('trip_id', $up_down_challan_ids)->sum('company_amount'):0;
        
        $data['up_down_challan_deposit'] = $data['up_down_advance_received'] + $data['up_down_after_advance'] + $data['up_down_demurrage_received'];
        $data['up_down_challan_expense'] = (count($up_down_challan_ids)>0)?Expense::whereIn('trip_id', $up_down_challan_ids)->sum('amount'):0;
        $data['up_down_challan_oil_expense'] = (count($up_down_challan_ids)>0)?TripOilExpense::whereIn('trip_id', $up_down_challan_ids)->sum('bill'):0;
        $data['up_down_challan_balance'] = $data['up_down_challan_deposit'] - ($data['up_down_challan_expense'] + $data['up_down_challan_oil_expense']);

        $data['up_down_challan_liter'] = (count($up_down_challan_ids)>0)?TripOilExpense::whereIn('trip_id', $up_down_challan_ids)->sum('liter'):0;
        $data['up_down_challan_distance'] = $up_down_challan->get()->sum('meter.current_reading') - $up_down_challan->get()->sum('meter.previous_reading');
        if($data['up_down_challan_distance'] > 0 &&  $data['up_down_challan_liter'] > 0){
            $data['up_down_challan_mileage'] = $data['up_down_challan_distance'] / $data['up_down_challan_liter'];
        } else {
            $data['up_down_challan_mileage'] = 0;
        }

        // outside of trip query -----------------------------------------------------------------------------------------------
        $data['outside_general_expense_of_trip'] = $outside_general_expense_of_trip->whereNull('trip_id')->get()->sum('amount');
        $data['outside_oil_expense_of_trip'] = $outside_oil_expense_of_trip->whereNull('trip_id')->get()->sum('bill');
        $data['outside_oil_liter_of_trip'] = $outside_oil_expense_of_trip->whereNull('trip_id')->get()->sum('liter');

        // pie charts -----------------------------------------------------------------------------------------------
        $data['pie_labels'] = [__('cmn.deposit'), __('cmn.expense'), __('cmn.due')];
        $data['pie_colors'] = ['#28a745', '#ffadad', '#ffc107'];
        // pie datas
        $data['pie_deposit'] = $data['single_challan_deposit'] + $data['up_down_challan_deposit'];
        $data['pie_expense'] = $data['single_challan_expense'] + $data['single_challan_oil_expense'] + $data['up_down_challan_expense']  + $data['up_down_challan_oil_expense'] + $data['outside_general_expense_of_trip'] + $data['outside_oil_expense_of_trip'];
        $data['pie_due'] = $data['single_challan_due'] + $data['up_down_challan_due'];
        $data['pie_datas'] = [$data['pie_deposit'], $data['pie_expense'], $data['pie_due']];

        return view('dashboard_two', $data);
    }



}