<?php

namespace App\Http\Controllers\Trip;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Trips\Trip;
use App\Models\Trips\TripChallan;
use App\Models\Trips\TripChallanReceivedHistory;
use App\Models\Accounts\Account;

use Toastr;
use Auth;
use Carbon\Carbon;
use DB;
use App\Http\Traits\AccountTransTrait;

class TripChallanReceivedController extends Controller {

    use AccountTransTrait;

    public function __construct(){
        $this->middleware('auth');
    }

    public function store(Request $request){

        // dd($request);
        $this->validate($request, [
            'trip_id' => 'required',
            'date' => 'required',
            'name' => 'required',
            'note' => 'nullable',
            'account_id' => 'nullable | integer'
        ]);

        DB::beginTransaction();
        try {

            // trips table
            $receivedHistory = new TripChallanReceivedHistory();
            $receivedHistory->trip_id = $request->input('trip_id');
            $receivedHistory->received_date = $request->input('date');
            $receivedHistory->receiver_name = $request->input('name');
            $receivedHistory->note = $request->input('note');
            $receivedHistory->created_by = Auth::user()->id;
            $receivedHistory->save();

            // comission deposit transection
            if($request->input('account_id')){

                $tripModel = Trip::find($request->input('trip_id'));
                $contract_comission = $tripModel->company->contract_fair - $tripModel->provider->contract_fair;

                if($contract_comission > 0){

                    $trip_date = Carbon::createFromFormat('Y-m-d', $tripModel->date)->format('d/m/Y');

                    // transection record
                    $trans['account_id'] = $request->input('account_id');
                    $trans['type'] = 'in';
                    $trans['amount'] = $contract_comission;
                    $trans['date'] = $trip_date;
                    $trans['transactionable_id'] = $tripModel->id;
                    $trans['transactionable_type'] = 'trip';
                    $trans['for'] = 'nagad_commission_has_been_received_from_a_trip';
                    $transaction = $this->transaction($trans);

                    // pivot table transection
                    $tripChallanModel = new TripChallan();
                    $tripChallanFillData = collect($tripChallanModel->getFillable());
                    $tripChallanFinalData = $tripChallanFillData->merge([
                        'trip_id' => $tripModel->id,
                        'account_transection_id' => $transaction->id,
                        'for'=> 'cash_comission',
                        'date'=> $trip_date,
                        'amount'=> $contract_comission,
                    ])->toArray();
                    $tripChallanModel->create($tripChallanFinalData);

                    $account = Account::where('id', $trans['account_id']);
                    $account->increment('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);
                    Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
                }
            }

            DB::commit();
            // back korbe
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
            // Toastr::error('', __('cmn.did_not_added'));
            // Toastr::error('', $e->getMessage());
            // return redirect()->back();
        }
    }

    public function destroy($id)
    {
        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        DB::beginTransaction();
        try {

            $tripChallanReceivedHistoryModel = TripChallanReceivedHistory::find($id);
            if($tripChallanReceivedHistoryModel->trip->transactions){

                TripChallan::where('trip_id', $id)->delete();
                $transections = $tripChallanReceivedHistoryModel->trip->transactions()->get();
                foreach($transections as $transection){
                    $account = Account::whereId($transection->account_id)->first();
                    if($transection->type == 'in'){
                        $account->decrement('balance', $transection->amount, ['updated_by'=> Auth::user()->id]);
                    } else {
                        $account->increment('balance', $transection->amount, ['updated_by'=> Auth::user()->id]);
                    }
                    $transection->update(['updated_by'=> Auth::user()->id]);
                    $transection->delete();
                }

                $tripChallanReceivedHistoryModel->update(['updated_by'=> Auth::user()->id]);
                $tripChallanReceivedHistoryModel->delete();
                Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            }
            
            // CommonService::activity($tableData->getTable(),$tableData->id,'deleted_this_item');
            DB::commit();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }


}