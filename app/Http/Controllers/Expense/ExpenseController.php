<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Trip\TripGeneralExpenseRequest;

use App\Models\Expenses\Expense;
use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingExpense;
use App\Models\Settings\SettingPump;
use App\Models\Accounts\Account;
use App\Models\Trips\TripOilExpense;


use App\Http\Traits\AccountTransTrait;
use App\Services\CommonService;

use Auth;
use Toastr;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use PDF;

class ExpenseController extends Controller
{
    use AccountTransTrait;

    public function index(Request $request)
    {
        // dd( $request);
        $data['menu'] = 'expense';
        $data['request'] = $request;
        $data['expenses'] = SettingExpense::orderBy('sort', 'asc')->get();
        $data['vehicles'] = SettingVehicle::all();

        $data['top_title'] = __('cmn.expenses');
        $data['title'] = __('cmn.expenses');
        $data['sub_menu'] = 'general_list';
        $data['accounts'] = Account::orderBy('sort', 'asc')->get();

        $time_start = microtime(true);

        $query = Expense::query();

        $query = $query->whereNull('trip_id');

        // if($request->input('expense_scope') == 'inside_of_challan'){
        //     $query = $query->whereNotNull('trip_id');

        // } elseif($request->input('expense_scope') == 'outside_of_challan'){
        //     $query = $query->whereNull('trip_id');
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

        if($request->input('expense_id')){
            $query = $query->where('expense_id', $request->input('expense_id'));
        }

        if($request->input('number')){
            $query->whereHas('trip', function($subQuery) use($request) {
                $subQuery->where('number', 'like', '%' . $request->input('number') . '%');
            });
        }

        if($request->input('voucher_id')){
            $query = $query->where('voucher_id', $request->input('voucher_id'));
        }

        if($request->input('vehicle_id')){
            $query = $query->where('vehicle_id', $request->input('vehicle_id'));
        }

        if($request->input('order_by')){ 
            if($request->input('order_by') == 'asc'){
                $query = $query->orderBy('date','ASC');
            }
            if($request->input('order_by') == 'desc'){
                $query = $query->orderBy('date','DESC');
            }
        } else {
            $query =  $query->orderBy('date','DESC');
        }

        if($request->input('per_page')){ 
            $per_page = $request->input('per_page');
        } else {
            $per_page = 50;
        }

        $data['lists'] = tap($query->paginate($per_page), function($value){
                        return $value->getCollection()->transform(function ($value) {
                            $value['date_for_edit'] = Carbon::parse($value['date'])->format('d/m/Y');
                            return $value;
                        });
                    });

        $time_gone = microtime(true) - $time_start;
        $data['execution_time'] = number_format((float)(($time_gone*1000)/1000), 4, '.', '');

        return view('expense.general_list', $data);
    }

    public function challanList(Request $request)
    {
        // dd( $request);

        $data['request'] = $request;
        $data['expenses'] = SettingExpense::orderBy('sort', 'asc')->get();
        $data['vehicles'] = SettingVehicle::all();

        $data['top_title'] = __('cmn.expenses');
        $data['title'] = __('cmn.expenses');
        $data['menu'] = 'expense';
        $data['sub_menu'] = 'challan_list';

        $time_start = microtime(true);

        $query = Expense::query();

        $query = $query->whereNotNull('trip_id');

        // if($request->input('expense_scope') == 'inside_of_challan'){
        //     $query = $query->whereNotNull('trip_id');
        // } elseif($request->input('expense_scope') == 'outside_of_challan'){
        //     $query = $query->whereNull('trip_id');
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

        if($request->input('expense_id')){
            $query = $query->where('expense_id', $request->input('expense_id'));
        }

        if($request->input('number')){
            $query->whereHas('trip', function($subQuery) use($request) {
                $subQuery->where('number', 'like', '%' . $request->input('number') . '%');
            });
        }

        if($request->input('vehicle_id')){
            $query = $query->where('vehicle_id', $request->input('vehicle_id'));
        }

        if($request->input('order_by')){ 
            if($request->input('order_by') == 'asc'){
                $query = $query->orderBy('date','ASC');
            }
            if($request->input('order_by') == 'desc'){
                $query = $query->orderBy('date','DESC');
            }
        } else {
            $query =  $query->orderBy('date','DESC');
        }

        if($request->input('per_page')){ 
            $per_page = $request->input('per_page');
        } else {
            $per_page = 50;
        }

        $data['lists'] = tap($query->paginate($per_page), function($value){
                        return $value->getCollection()->transform(function ($value) {
                            $value['date_for_edit'] = Carbon::parse($value['date'])->format('d/m/Y');
                            return $value;
                        });
                    });

        $time_gone = microtime(true) - $time_start;
        $data['execution_time'] = number_format((float)(($time_gone*1000)/1000), 4, '.', '');

        return view('expense.challan_list', $data);
    }

    public function store(TripGeneralExpenseRequest $request)
    {

        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        if(!setting('admin_system.zero_balance_transection')){
            if($request->input('amount') > Account::find($request->input('account_id'))->balance){
                Toastr::error('',__('cmn.there_is_no_sufficient_balance_in_the_payment_account_so_the_transaction_is_not_acceptable'));
                return redirect()->back();
            }
        }

        DB::beginTransaction();
        try {

            $model = new Expense();
            $finalData = collect($request->only($model->getFillable()))
                            ->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id])
                            ->toArray();
            $expense = $model->create($finalData);

            // expense transection
            $trans['account_id'] = $request->input('account_id');
            $trans['type'] = 'out';
            $trans['amount'] =  $request->input('amount');
            $trans['date'] = $request->input('date');
            $trans['for'] = 'has_been_spent';
            $trans['note'] = $request->input('note');
            $trans['transactionable_id'] = $expense->id;
            $trans['transactionable_type'] = 'expense';
            $this->transaction($trans);

            // account
            $account = Account::where('id', $trans['account_id']);
            $account->decrement('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);

            DB::commit();
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back();
            
        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
    }

    public function update(TripGeneralExpenseRequest $request, $id)
    {
        // dd($request);

        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        DB::beginTransaction();
        try{

            // expense update
            $expenseModel = Expense::find($id);
            $expenseModel->vehicle_id = $request->input('vehicle_id');
            $expenseModel->trip_id = null;
            $expenseModel->expense_id = $request->input('expense_id');
            $expenseModel->voucher_id = $request->input('voucher_id');
            $expenseModel->amount = $request->input('amount');
            $expenseModel->date = $request->input('date');
            $expenseModel->note = $request->input('note');
            $expenseModel->updated_by = Auth::user()->id;
            $expenseModel->save();

            // account id is changed
            $transection = $expenseModel->transaction()->first();

            // if new account and old account is not same
            if($request->input('account_id') != $transection->account_id){

                // delete old transection
                $acc = Account::whereId($transection->account_id);
                $acc->increment('balance', $expenseModel->amount, ['updated_by'=> Auth::user()->id]);
                $expenseModel->transaction()->delete();

                // run new expense transection
                $trans['account_id'] = $request->input('account_id');
                $trans['type'] = 'out';
                $trans['amount'] =  $request->input('amount');
                $trans['date'] = $request->input('date');
                $trans['for'] = 'has_been_spent';
                $trans['note'] = $request->input('note');
                $trans['transactionable_id'] = $id;
                $trans['transactionable_type'] = 'expense';
                $this->transaction($trans);

                // account
                $account = Account::where('id', $trans['account_id']);
                $account->decrement('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);
            
            // if keep old account but amount is changed
            } elseif($request->input('amount') != $transection->amount){

                // updated amount is bigger then old then increment
                if($request->input('amount') > $transection->amount){

                    $added_amount = $request->input('amount') - $transection->amount;
                    $transection->update(['amount'=> $request->input('amount'), 'date'=> $request->input('date'), 'updated_by'=> Auth::user()->id]);

                    // added amount need to decrease from current account
                    $account = Account::where('id', $transection->account_id);
                    $account->decrement('balance', $added_amount, ['updated_by'=> Auth::user()->id]);

                // updated amount is smaller then old then decriment
                } elseif($request->input('amount') < $transection->amount){

                    $minus_amount = $transection->amount - $request->input('amount');
                    $transection->update(['amount'=> $request->input('amount'), 'date'=> $request->input('date'), 'updated_by'=> Auth::user()->id]);

                    // minus amount need to increase from current account
                    $account = Account::where('id', $transection->account_id);
                    $account->increment('balance', $minus_amount, ['updated_by'=> Auth::user()->id]);

                } else {
                    $transection->update(['date'=> $request->input('date'), 'updated_by'=> Auth::user()->id]);
                }

            } else {
                $transection->update(['date'=> $request->input('date'), 'updated_by'=> Auth::user()->id]);
            }

            DB::commit();
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back();

        }catch (\Exception $e) {

            DB::rollBack();
            Toastr::error('',__('cmn.did_not_updated'));
            return redirect()->back();
        }
    }

    public function destroy($id){
        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        if (!Expense::where('id', $id)->exists()) {
            Toastr::error(__('cmn.did_not_find'),__('cmn.sorry'));
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $expense = Expense::find($id);
            // account increment
            $transection = $expense->transaction()->first();
            $account = Account::whereId($transection->account_id);
            $account->increment('balance', $expense->amount, ['updated_by'=> Auth::user()->id]);
            // expnse
            $expense->update(['updated_by'=> Auth::user()->id]);
            $expense->transaction()->delete();
            $expense->delete();
            DB::commit();
            Toastr::success('',__('cmn.account_transactions_successfully_removed_and_balance_updated'));
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        }catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('cmn.did_not_deleted'),__('cmn.sorry'));
            return redirect()->back();
        }
    }

    public function reportForm(Request $request){

        $data['request'] = $request;
        $data['menu'] = 'expense';
        $data['sub_menu'] = 'expense_report';

        $data['top_title'] = __('cmn.expense_report_form');
        $data['title'] = __('cmn.expense_report_form');

        $data['expenses'] = SettingExpense::orderBy('sort', 'asc')->get();
        $data['vehicles'] = SettingVehicle::orderBy('sort', 'asc')->get();

        return view('expense.report_form', $data);

    }

    public function expenseReport(Request $request){

        ini_set('max_execution_time', '600'); // 10 minutes
        ini_set("pcre.backtrack_limit", "5000000");

        if(!$request->has('format')){
            Toastr::warning('format not defined', 'Sorry');
            return redirect()->back();
        }

        $data['reporting_time'] = date('d M, Y h:i:s a');
        $data['title'] =  __('cmn.expense_report');
        $data['menu'] = 'report';
        $data['sub_menu'] = 'expense_report';
        $data['request'] = $request;

        switch ($request->input('format')) {

            case 'first_format':
                return $this->first_format($request, $data);
                break;

            case 'second_format':
                return $this->second_format($request, $data);
                break;

            case 'third_format':
                return $this->third_format($request, $data);
                break;
            
            case 'four_format':
                return $this->four_format($request, $data);
                break;

                

        }
    }

    public function first_format($request, $data){

        ini_set('max_execution_time', '600'); // 10 minutes
        ini_set("pcre.backtrack_limit", "5000000");

        $format = $request->input('format');
        $date_range_status = $request->input('date_range_status');
        $month = $request->input('month');
        $year = $request->input('year');
        $expense_id = $request->input('expense_id');
        $vehicle_id = $request->input('vehicle_id');
        $date_range_status = $request->input('date_range_status');
        $daterange = $request->input('daterange');
        $expense_scope = $request->input('expense_scope');
        $data['page_header'] = $request->input('page_header');

        $query = Expense::with('expense');

        if($expense_scope == 'inside_of_challan'){
            $data['title'] .= ' ('. __('cmn.inside_of_challan') . ')';
            $query = $query->whereNotNull('trip_id');

        } elseif($expense_scope == 'outside_of_challan'){
            $data['title'] .= ' ('. __('cmn.outside_of_challan') . ')';
            $query = $query->whereNull('trip_id');
        }
        
        if($expense_id){
            $expense = SettingExpense::where('id', $expense_id)->first();
            $data['title'] .= ' ('. __('cmn.expense_head') . ' - ' .  $expense->head . ')';
            $query = $query->where('expense_id', $expense_id);
        }
        if($vehicle_id){
            $vehicle = SettingVehicle::where('id', $vehicle_id)->first();
            $data['title'] .= ' ('. __('cmn.vehicle_number') . ' - ' .  $vehicle->number_plate . ')';
            $query = $query->where('vehicle_id', $vehicle_id);
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

        // date wise
        if($date_range_status == 'date_wise' && $daterange){
            
            $date = explode(' - ', $daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
            
            $query = $query->whereBetween('date', [$start_date, $end_date]);
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

        // assign page config
        $config['format'] = $request->input('size');
        $pdf = PDF::loadView('expense.report.first_format', $data, [], $config);


        if($request->input('download_pdf') == 'true'){
            return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        } else {
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }
    }

    public function second_format($request, $data){

        ini_set('max_execution_time', '600'); // 10 minutes
        ini_set("pcre.backtrack_limit", "5000000");

        // $format = $request->input('format');
        // $vehicle_id = $request->input('vehicle_id');
        $date_range_status = $request->input('date_range_status');
        $month = $request->input('month');
        $year = $request->input('year');
        $daterange = $request->input('daterange');
        $expense_ids =  $request->input('expense_ids')??false;
        $vehicle_ids =  $request->input('vehicle_ids')??false;
        $expense_scope = $request->input('expense_scope');
        $data['page_header'] = $request->input('page_header');

        // dd($request);
        $data['setting_expenses'] = [];
        if($expense_ids){
            $data['setting_expenses'] = SettingExpense::whereIn('id', $expense_ids)->orderBy('sort', 'asc')->get();
        } else {
            Toastr::error(__('cmn.expense_must_be_required'),__('cmn.sorry'));
            return redirect()->back();
        }
        
        $data['setting_vehicles'] = [];
        if($vehicle_ids){
            $data['setting_vehicles'] = SettingVehicle::whereIn('id', $vehicle_ids)->orderBy('sort', 'asc')->get();
        }

        $data['request'] = $request;

        // validation ta ekhane dibo
        switch ($date_range_status) {

            case 'all_time':
                $data['title'] .= ' - (' . __('cmn.all_time') . ')';
                break;

            case 'monthly_report':
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
                break;
            
            case 'yearly_report':
                if(!$year){
                    Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                    return redirect()->back();
                }
                $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
                break;
    
            case 'date_wise':
                $date = explode(' - ', $daterange);
                $start_date = Carbon::parse($date[0])->startOfDay();
                $end_date = Carbon::parse($date[1])->endOfDay();
                $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
                
                // if format type = 'according to date'
                if($request->input('format_type') == 'accordint_to_date'){
                    $data['dates'] = CarbonPeriod::create($start_date, $end_date);
                }
                break;

        }

        if($expense_scope == 'inside_of_challan'){
            $data['title'] .= ' - ('. __('cmn.inside_of_challan') . ')';
        
        } elseif($expense_scope == 'outside_of_challan'){
            $data['title'] .= ' - ('. __('cmn.outside_of_challan') . ')';
        }

        // assign page config
        $config['format'] = $request->input('size');
        $pdf = PDF::loadView('expense.report.new_second_format', $data, [], $config);

        if($request->input('download_pdf') == 'true'){
            return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        } else {
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }
    }

    public function third_format($request, $data){

        ini_set('max_execution_time', '600'); // 10 minutes
        ini_set("pcre.backtrack_limit", "5000000");

        // $format = $request->input('format');
        // $vehicle_id = $request->input('vehicle_id');
        $date_range_status = $request->input('date_range_status');
        $month = $request->input('month');
        $year = $request->input('year');
        $daterange = $request->input('daterange');
        $expense_ids =  $request->input('expense_ids_3')??false;
        $vehicle_ids =  $request->input('vehicle_ids_3')??false;
        $expense_scope = $request->input('expense_scope');
        $data['page_header'] = $request->input('page_header');

        // dd($request);
        $data['setting_expenses'] = [];
        if($expense_ids){
            $data['setting_expenses'] = SettingExpense::whereIn('id', $expense_ids)->orderBy('sort', 'asc')->get();
        } else {
            Toastr::error(__('cmn.expense_must_be_required'),__('cmn.sorry'));
            return redirect()->back();
        }
        
        $data['request'] = $request;

        // validation ta ekhane dibo
        switch ($date_range_status) {

            case 'all_time':
                $data['title'] .= ' - (' . __('cmn.all_time') . ')';
                break;

            case 'monthly_report':
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

                // $data['ranges'] = [1,2,3,4,5,6,7,8,9,10,11,12];
                // $start_date_of_month = Carbon::createFromDate($year, $month)->startOfMonth();
                // $end_date_of_month = Carbon::createFromDate($year, $month)->endOfMonth();

                $start_date_of_month = Carbon::createFromFormat('!Y-m', "$year" . '-' . "$month")->startOfMonth();
                $end_date_of_month = Carbon::createFromFormat('!Y-m', "$year" . '-' . "$month")->endOfMonth();

                $data['ranges'] = CarbonPeriod::create($start_date_of_month, $end_date_of_month);
                $data['year'] = $year;
                break;
            
            case 'yearly_report':
                if(!$year){
                    Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                    return redirect()->back();
                }
                $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';

                $data['ranges'] = ['january',
                                'february',
                                'march',
                                'april',
                                'may',
                                'june',
                                'july',
                                'august',
                                'september',
                                'october',
                                'november',
                                'december'];
                $data['year'] = $year;
                break;
    
            case 'date_wise':
                $date = explode(' - ', $daterange);
                $start_date = Carbon::parse($date[0])->startOfDay();
                $end_date = Carbon::parse($date[1])->endOfDay();
                $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
                
                $data['ranges'] = CarbonPeriod::create($start_date, $end_date);
                break;

        }

        $data['setting_vehicles'] = [];
        if($vehicle_ids){

            $data['title'] .= ' - (' . __('cmn.vehicle_no') . ' - ';
            $data['setting_vehicles'] = SettingVehicle::whereIn('id', $vehicle_ids)->orderBy('sort', 'asc')->get();

            foreach($data['setting_vehicles'] as $key => $setting_vehicle){
                $data['title'] .=  (($key>0)?', ':'') . $setting_vehicle->number_plate;
            }

            $data['title'] .= ')';
        }

        if($expense_scope == 'inside_of_challan'){
            $data['title'] .= ' - ('. __('cmn.inside_of_challan') . ')';
        
        } elseif($expense_scope == 'outside_of_challan'){
            $data['title'] .= ' - ('. __('cmn.outside_of_challan') . ')';
        }

        // assign page config
        $config['format'] = $request->input('size');
        $pdf = PDF::loadView('expense.report.third_format', $data, [], $config);

        if($request->input('download_pdf') == 'true'){
            return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        } else {
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }

    }

    public function four_format($request, $data){

        ini_set('max_execution_time', '600'); // 10 minutes
        ini_set("pcre.backtrack_limit", "5000000");

        // assign request
        $format = $request->input('format');
        $date_range_status = $request->input('date_range_status');
        $month = $request->input('month');
        $year = $request->input('year');
        $daterange = $request->input('daterange');
        $data['page_header'] = $request->input('page_header');
        $data['request'] = $request;

        $data['setting_expenses'] = SettingExpense::orderBy('sort', 'asc')->get();

        $query = Expense::with('expense')->select('voucher_id');
        
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

        // date wise
        if($date_range_status == 'date_wise' && $daterange){
            
            $date = explode(' - ', $daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
            
            $query = $query->whereBetween('date', [$start_date, $end_date]);
        }

        if($request->input('order_by')){ 
            if($request->input('order_by') == 'asc'){
                $query = $query->orderBy('id','ASC');
            }
            if($request->input('order_by') == 'desc'){
                $query = $query->orderBy('id','DESC');
            }
        }

        $data['lists'] = $query->groupBy('voucher_id')->get();
        // dd($data);

        // assign page config
        $config['format'] = $request->input('size');
        $pdf = PDF::loadView('expense.report.fourth_format', $data, [], $config);

        if($request->input('download_pdf') == 'true'){
            return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        } else {
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }
    }



}
