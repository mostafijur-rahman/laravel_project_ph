<?php

namespace App\Http\Controllers\Expense;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Requests\Expense\OilExpenseRequest;


// use App\Models\Expenses\Expense;
use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingPump;
use App\Models\Accounts\Account;
use App\Models\Trips\TripOilExpense;

use App\Http\Traits\AccountTransTrait;
use App\Services\CommonService;

use Auth;
use Toastr;
use Carbon\Carbon;
use DB;
use PDF;

class OilExpenseController extends Controller
{
    use AccountTransTrait;

    public function index(Request $request)
    {

        $data['request'] = $request;
        $data['top_title'] = __('cmn.oil_expenses');
        $data['title'] = __('cmn.oil_expenses');
        $data['menu'] = 'expense';
        $data['sub_menu'] = 'oil_list';

        $data['accounts'] = Account::orderBy('sort', 'asc')->get();
        $data['pumps'] = SettingPump::orderBy('sort', 'asc')->get();
        $data['vehicles'] = SettingVehicle::all();

        $time_start = microtime(true);

        $query = TripOilExpense::query();

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

        return view('expense.oil_list', $data);

    }

    
    public function store(OilExpenseRequest $request)
    {
        // dd($request);

        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        try {
            DB::beginTransaction();
            $oilExpenseModel = new TripOilExpense();

            $oilExpenseModel->encrypt = uniqid();
            $oilExpenseModel->vehicle_id = $request->input('vehicle_id');
            $oilExpenseModel->trip_id = $request->input('trip_id');
            $oilExpenseModel->pump_id = $request->input('pump_id');
            $oilExpenseModel->voucher_id = $request->input('voucher_id');
            $oilExpenseModel->liter = $request->input('liter');
            $oilExpenseModel->rate = $request->input('rate');

            $oilExpenseModel->bill = $request->input('liter')*$request->input('rate');
            $oilExpenseModel->date = $request->input('date');
            $oilExpenseModel->note = $request->input('note');
            $oilExpenseModel->created_by = Auth::user()->id;
            $oilExpenseModel->save();

            if(!setting('admin_system.zero_balance_transection')){
                if($request->input('liter')*$request->input('rate') > Account::find($request->input('account_id'))->balance){
                    Toastr::error('',__('cmn.there_is_no_sufficient_balance_in_the_payment_account_so_the_transaction_is_not_acceptable'));
                    return redirect()->back();
                }
            }

            // transection
            $trans['account_id'] = $request->input('account_id');
            $trans['type'] = 'out';
            $trans['amount'] = $request->input('liter')*$request->input('rate');
            $trans['date'] = $request->input('date'); //Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('d/m/Y');
            $trans['transactionable_id'] = $oilExpenseModel->id;
            $trans['transactionable_type'] = 'trip_oil_expense';
            $trans['for'] = 'oil_expense';
            $this->transaction($trans);

            // account
            $account = Account::where('id', $trans['account_id']);
            $account->decrement('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);

            DB::commit();
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back();

        }catch (\Exception $e) {
            DB::rollback();
            // dd($e->getMessage());
            Toastr::error('',__('cmn.did_not_posted'));
            return redirect()->back();
        }
    }

    public function update(OilExpenseRequest $request, $id)
    {

        // dd($request);

        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        DB::beginTransaction();
        try{

            // expense update
            $amount = $request->input('liter')*$request->input('rate');
            $oilExpenseModel = TripOilExpense::find($id);

            $oilExpenseModel->vehicle_id = $request->input('vehicle_id');
            $oilExpenseModel->pump_id = $request->input('pump_id');
            $oilExpenseModel->voucher_id = $request->input('voucher_id');
            $oilExpenseModel->liter = $request->input('liter');
            $oilExpenseModel->rate = $request->input('rate');

            $oilExpenseModel->bill = $amount;
            $oilExpenseModel->date = $request->input('date');
            $oilExpenseModel->note = $request->input('note');
            $oilExpenseModel->created_by = Auth::user()->id;
            $oilExpenseModel->save();

            // account id is changed
            $transection = $oilExpenseModel->transaction()->first();

            // if new account and old account is not same
            if($request->input('account_id') != $transection->account_id){

                // delete old transection
                $acc = Account::whereId($transection->account_id);
                $acc->increment('balance', $amount, ['updated_by'=> Auth::user()->id]);
                $oilExpenseModel->transaction()->delete();

                // run new expense transection
                $trans['account_id'] = $request->input('account_id');
                $trans['type'] = 'out';
                $trans['amount'] = $amount;
                $trans['date'] = $request->input('date'); //Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('d/m/Y');
                $trans['transactionable_id'] = $oilExpenseModel->id;
                $trans['transactionable_type'] = 'trip_oil_expense';
                $trans['for'] = 'oil_expense';
                $this->transaction($trans);

                // account
                $account = Account::where('id', $trans['account_id']);
                $account->decrement('balance', $amount, ['updated_by'=> Auth::user()->id]);
            
            // if keep old account but amount is changed
            } elseif($amount != $transection->amount){

                // updated amount is bigger then old then increment
                if($amount > $transection->amount){

                    $added_amount = $amount - $transection->amount;
                    $transection->update(['amount'=> $amount, 'date'=> $request->input('date'), 'updated_by'=> Auth::user()->id]);

                    // added amount need to decrease from current account
                    $account = Account::where('id', $transection->account_id);
                    $account->decrement('balance', $added_amount, ['updated_by'=> Auth::user()->id]);

                // updated amount is smaller then old then decriment
                } elseif($amount < $transection->amount){

                    $minus_amount = $transection->amount - $amount;
                    $transection->update(['amount'=> $amount, 'date'=> $request->input('date'), 'updated_by'=> Auth::user()->id]);

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

        if (!TripOilExpense::where('id', $id)->exists()) {
            Toastr::error(__('cmn.did_not_find'),__('cmn.sorry'));
            return redirect()->back();
        }

        try {
            DB::beginTransaction();

            $tripOilExpense = TripOilExpense::find($id);

            // account increment
            $transection = $tripOilExpense->transaction()->first();
            $account = Account::whereId($transection->account_id);
            $account->increment('balance', $tripOilExpense->bill, ['updated_by'=> Auth::user()->id]);

            // expense
            $tripOilExpense->update(['updated_by'=> Auth::user()->id]);
            $tripOilExpense->transaction()->delete();
            $tripOilExpense->delete();
            DB::commit();

            Toastr::success('',__('cmn.successfully_deleted'));
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            return redirect()->back();
            
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }

    
}
