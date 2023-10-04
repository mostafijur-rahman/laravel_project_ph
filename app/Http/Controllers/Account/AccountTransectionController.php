<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

// models
use App\Models\Accounts\Account;
use App\Models\Accounts\AccountTransection;
use Illuminate\Http\Request;
use App\Http\Traits\AccountTransTrait;
use App\Models\Settings\SettingInvestor;

// Request
use App\Http\Requests\Account\AccountTransectionRequest;
use App\Http\Requests\Account\AccountBalanceTransferRequest;

use Auth;
use Toastr;
use DB;
use Carbon\Carbon;

class AccountTransectionController extends Controller
{
    use AccountTransTrait;

    public function index(Request $request)
    {
        $data['menu'] = 'accounts';
        $data['accounts'] = Account::get();
        $data['investors'] = SettingInvestor::get();
        $data['lists'] = AccountTransection::orderBy('id','desc')->paginate(100);

        if($request->input('page_name') == 'only_transections'){
            $data['top_title'] = __('cmn.all').' '.__('cmn.transactions');
            $data['title'] = __('cmn.all').' '.__('cmn.transactions');
            $data['menu'] = 'only_transections';
            $data['accounts'] = Account::orderBy('id','desc')->get();
            return view('account.only_account_transection', $data);
        }

        if($request->input('page_name') == 'transections'){
            $data['top_title'] = __('cmn.transactions').' '.__('cmn.list');
            $data['title'] = __('cmn.transactions').' '.__('cmn.list');
            $data['sub_menu'] = 'account_transection';
            return view('account.account_transection', $data);
        }
        
        if($request->input('page_name') == 'balance_transfer'){
            $data['top_title'] = __('cmn.balance_transfer');
            $data['title'] = __('cmn.balance_transfer');
            $data['sub_menu'] = 'balance_transfer';
            return view('account.balance_transfer', $data);
        }
    }

    public function store(AccountTransectionRequest $request)
    {
        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        if(($request->input('type') == 'out') && $request->input('amount') > Account::find($request->input('account_id'))->balance){
            Toastr::error('',__('cmn.can_not_cash_out_due_to_insufficient_balance'));
            return redirect()->back();
        }
        DB::beginTransaction();
        try {
            $account = Account::where('id',$request->input('account_id'));
            if($request->input('type') == 'in'){
                $account->increment('balance', $request->input('amount'), ['updated_by'=> Auth::user()->id]);
                $for = 'cash_in';
            } else {
                $account->decrement('balance', $request->input('amount'), ['updated_by'=> Auth::user()->id]);
                $for = 'cash_out';
            }
            $model = new AccountTransection();
            $finaldata = collect($request->only($model->getFillable()))
                            ->merge(['encrypt'=> uniqid(), 'for'=> $for, 'created_by'=> Auth::user()->id])
                            ->toArray();
            $model->create($finaldata);
            DB::commit();
            Toastr::success('',__('cmn.successfully_posted'));
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request,[
            'date' => "required",
            'note' => "nullable",
        ]);
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        DB::beginTransaction();
        try {
            $accountTrans = AccountTransection::find($id);
            $accountTrans->date = Carbon::createFromFormat('Y-m-d', $request->input('date'))->format('d/m/Y');
            $accountTrans->note = $request->input('note');
            $accountTrans->updated_by = Auth::user()->id;
            $accountTrans->update();
            DB::commit();
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        Toastr::error('',__('cmn.this_feature_has_been_disabled'));
        return redirect()->back();
        
        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        if (!AccountTransection::find($id)->exists()) {
            Toastr::error(__('cmn.did_not_find'),__('cmn.sorry'));
            return redirect()->back();
        }
        try {
            $account_transection = AccountTransection::find($id);
            $account_transection->update(['updated_by'=> Auth::user()->id]);
            $account_transection->delete();
            Toastr::success(__('cmn.successfully_deleted'),__('cmn.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            Toastr::error(__('cmn.did_not_deleted'),__('cmn.sorry'));
            return redirect()->back();
        }
    }

    public function balanceTransfer(AccountBalanceTransferRequest $request)
    {
        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        if($request->input('amount') <= 0){
            Toastr::error('',__('cmn.give_the_correct_amount'));
            return redirect()->back();
        }
        if($request->input('sender_account_id') == $request->input('recipient_account_id')){
            Toastr::error('',__('cmn.balance_cannot_be_transferred_to_the_same_account'));
            return redirect()->back();
        }
        if($request->input('amount') > Account::find($request->input('sender_account_id'))->balance){
            Toastr::error('',__('cmn.there_is_no_balance_in_the_senders_account_so_the_balance_transfer_is_not_acceptable'));
            return redirect()->back();
        }
        DB::beginTransaction();
        try {
            // out transection
            $transOut['account_id'] = $request->input('sender_account_id');
            $transOut['type'] = 'out';
            $transOut['amount'] =  $request->input('amount');
            $transOut['date'] =$request->input('date');
            $transOut['for'] = 'balance_transferred'; // $request->input('recipient_account_id');
            $transOut['note'] = $request->input('note');
            $this->transaction($transOut);
            // decrement
            $account = Account::where('id',$request->input('sender_account_id'));
            $account->decrement('balance', $request->input('amount'), ['updated_by'=> Auth::user()->id]);

            // in transection
            $transIn['account_id'] = $request->input('recipient_account_id');
            $transIn['type'] = 'in';
            $transIn['amount'] =  $request->input('amount');
            $transIn['date'] =$request->input('date');
            $transIn['for'] = 'transferred_balance_has_been_accepted'; // .$request->input('sender_account_id')
            $transIn['note'] = $request->input('note');
            $this->transaction($transIn);
            // increment
            $account = Account::where('id',$request->input('recipient_account_id'));
            $account->increment('balance', $request->input('amount'), ['updated_by'=> Auth::user()->id]);

            DB::commit();
            Toastr::success('',__('cmn.successfully_posted'));
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            return redirect()->back();
        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
    }


}
