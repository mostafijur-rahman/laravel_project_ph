<?php

namespace App\Http\Controllers\Trip;
use App\Http\Controllers\Controller;
use App\Http\Traits\AccountTransTrait;

// request
use Illuminate\Http\Request;
// use App\Http\Requests\Trip\TripDemurrageRequest;
use App\Http\Requests\Trip\Transection\OutCommissionTransectionRequest; 
use App\Http\Requests\Trip\Transection\OwnVehicleSingleRequest; 
use App\Http\Requests\Trip\Transection\OwnVehicleUpDownRequest; 


// model
use App\Models\Trips\Trip;
use App\Models\Trips\TripCompany;
use App\Models\Trips\TripProvider;
use App\Models\Trips\TripChallan;
use App\Models\Accounts\Account;
use App\Models\Accounts\AccountTransection;

// other class
use DB;
use Toastr;
use Auth;

class TransectionController extends Controller {

    use AccountTransTrait;

    public function forSingleChallan(OwnVehicleSingleRequest $request){

        // request assign
        $trip_id = $request->input('trip_id');
        $company_id = $request->input('company_id');
        $transection_type = $request->input('transection_type');
        $date = $request->input('date');
        $account_id = $request->input('account_id');
        $voucher_id = $request->input('voucher_id');
        $amount = $request->input('amount');
        $recipients_name = $request->input('recipients_name');
        $recipients_phone = $request->input('recipients_phone');

        DB::beginTransaction();
        try {

            // fetch trip company
            if(TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->exists()){

                $tripCompany = TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->first();

            } else {
                Toastr::error('', __('cmn.trip_or_company_data_not_found'));
                return redirect()->back();
            }

            // due amount fetch from database
            switch ($transection_type) {
                case 'receive_challan_due_from_company':
                    $due_amount = $tripCompany->due_fair;
                    break;
                case 'receive_demurrage_due_from_company':
                    $due_amount = $tripCompany->demarage_due;
                    break;
            }
            
            // if due amount 0 then return back
            if($due_amount == 0){
                Toastr::error('', __('cmn.no_due'));
                return redirect()->back();
            }
            
            // if due posting amount is greate then due amount
            if($amount > $due_amount){
                Toastr::error('',  __('cmn.the_post_amount_is_more_than_the_due_amount_so_posting_is_not_valid'));
                return redirect()->back();
            }

            // amount increase from database
            switch ($transection_type) {

                case 'receive_challan_due_from_company':
                    $left_amount = $due_amount - $amount;
                    $tripCompany->received_fair += $amount; // increase deposit
                    $tripCompany->due_fair = $left_amount; // decrease due
                    $for = 'challan_bill_has_been_received_from_the_company_for_the_trip';

                    $challan_for = 'company_trip';
                    break;
                    
                case 'receive_demurrage_due_from_company':
                    $left_amount = $due_amount - $amount;
                    $tripCompany->demarage_received += $amount; // increase deposit
                    $tripCompany->demarage_due = $left_amount; // decrease due
                    $for = 'demurrage_has_been_received_from_the_company_for_the_trip';

                    $challan_for = 'company_demurrage';
                    break;

            }
            $tripCompany->save();

            // transection
            $trans['account_id'] = $account_id;
            $trans['amount'] = $amount;
            $trans['type'] = 'in';
            $trans['date'] = $date;
            $trans['transactionable_id'] = $tripCompany->trip_id;
            $trans['transactionable_type'] = 'trip';
            $trans['for'] = $for;
            $transaction = $this->transaction($trans);

            // pivot table transection
            $tripChallanModel = new TripChallan();
            $tripChallanFillData = collect($request->only($tripChallanModel->getFillable()));
            $tripChallanFinalData = $tripChallanFillData->merge(['trip_id' => $tripCompany->trip_id,
                                                'account_transection_id' => $transaction->id,
                                                'for'=> $challan_for])->toArray();
            $tripChallanModel->create($tripChallanFinalData);

            // account update
            $account = Account::where('id', $trans['account_id']);
            $account->increment('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);

            DB::commit();
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            return redirect()->back();
        }catch (ModelNotFoundException $e) {
            DB::rollback();
            // dd($e->message());
            Toastr::error(__('cmn.sorry'), $e->message());
            return redirect()->back();
        }
    }

    public function forUpDownChallan(OwnVehicleUpDownRequest $request){

        // request assign
        $transection_type = $request->input('transection_type');
        $date = $request->input('date');
        $account_id = $request->input('account_id');
        $voucher_id = $request->input('voucher_id');
        $amount = $request->input('amount');
        $recipients_name = $request->input('recipients_name');
        $recipients_phone = $request->input('recipients_phone');

        // consider as up down challan
        switch ($transection_type) {

            case 'receive_challan_due_from_company_for_up_challan':
                $trip_id = $request->input('trip_id');
                break;

            case 'receive_demurrage_due_from_company_for_up_challan':
                $trip_id = $request->input('trip_id');
                break;

            case 'receive_challan_due_from_company_for_down_challan':
                $trip_id = $request->input('down_trip_id');
                break;

            case 'receive_demurrage_due_from_company_for_down_challan':
                $trip_id = $request->input('down_trip_id');
                break;
        }

        $trip_info = Trip::with('company')->where('id', $trip_id)->first();
        $company_id = $trip_info->company->company_id;

        DB::beginTransaction();
        try {

            // fetch trip company
            if(TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->exists()){

                $tripCompany = TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->first();
                

            } else {
                Toastr::error('', __('cmn.trip_or_company_data_not_found'));
                return redirect()->back();
            }

            // due amount fetch from database
            switch ($transection_type) {

                case 'receive_challan_due_from_company_for_up_challan':
                    $due_amount = $tripCompany->due_fair;
                    break;
    
                case 'receive_demurrage_due_from_company_for_up_challan':
                    $due_amount = $tripCompany->demarage_due;
                    break;
    
                case 'receive_challan_due_from_company_for_down_challan':
                    $due_amount = $tripCompany->due_fair;
                    break;
    
                case 'receive_demurrage_due_from_company_for_down_challan':
                    $due_amount = $tripCompany->demarage_due;
                    break;
            }

            // if due amount 0 then return back
            if($due_amount == 0){
                Toastr::error('', __('cmn.no_due'));
                return redirect()->back();
            }
            
            // if due posting amount is greate then due amount
            if($amount > $due_amount){
                Toastr::error('',  __('cmn.the_post_amount_is_more_than_the_due_amount_so_posting_is_not_valid'));
                return redirect()->back();
            }

            // data modify from database
            switch ($transection_type) {

                case 'receive_challan_due_from_company_for_up_challan':
                    $left_amount = $due_amount - $amount;
                    $tripCompany->received_fair += $amount; // increase deposit
                    $tripCompany->due_fair = $left_amount; // decrease due
                    $for = 'challan_bill_has_been_received_from_the_company_for_the_trip';

                    $challan_for = 'company_trip';
                    break;
    
                case 'receive_demurrage_due_from_company_for_up_challan':
                    $left_amount = $due_amount - $amount;
                    $tripCompany->demarage_received += $amount; // increase deposit
                    $tripCompany->demarage_due = $left_amount; // decrease due
                    $for = 'demurrage_has_been_received_from_the_company_for_the_trip';

                    $challan_for = 'company_demurrage';
                    break;
    
                case 'receive_challan_due_from_company_for_down_challan':
                    $left_amount = $due_amount - $amount;
                    $tripCompany->received_fair += $amount; // increase deposit
                    $tripCompany->due_fair = $left_amount; // decrease due
                    $for = 'challan_bill_has_been_received_from_the_company_for_the_trip';

                    $challan_for = 'company_trip';
                    break;
    
                case 'receive_demurrage_due_from_company_for_down_challan':
                    $left_amount = $due_amount - $amount;
                    $tripCompany->demarage_received += $amount; // increase deposit
                    $tripCompany->demarage_due = $left_amount; // decrease due
                    $for = 'demurrage_has_been_received_from_the_company_for_the_trip';

                    $challan_for = 'company_demurrage';
                    break;
            }
            $tripCompany->save();

            // transection
            $trans['account_id'] = $account_id;
            $trans['amount'] = $amount;
            $trans['type'] = 'in';
            $trans['date'] = $date;
            $trans['transactionable_id'] = $trip_id;
            $trans['transactionable_type'] = 'trip';
            $trans['for'] = $for;
            $transaction = $this->transaction($trans);

            // pivot table transection
            $tripChallanModel = new TripChallan();
            $tripChallanFillData = collect($request->only($tripChallanModel->getFillable()));
            $tripChallanFinalData = $tripChallanFillData->merge(['trip_id' => $tripCompany->trip_id,
                                                'account_transection_id' => $transaction->id,
                                                'for'=> $challan_for])->toArray();
            $tripChallanModel->create($tripChallanFinalData);

            // account update
            $account = Account::where('id', $trans['account_id']);
            $account->increment('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);

            DB::commit();
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            return redirect()->back();
        }catch (ModelNotFoundException $e) {
            DB::rollback();
            // dd($e->message());
            Toastr::error(__('cmn.sorry'), $e->message());
            return redirect()->back();
        }
    }

    public function forOutCommissionTransection(OutCommissionTransectionRequest $request){

        // request assign
        $trip_id = $request->input('trip_id');
        $company_id = $request->input('company_id');
        $transection_type = $request->input('transection_type');
        $date = $request->input('date');
        $account_id = $request->input('account_id');
        $voucher_id = $request->input('voucher_id');
        $amount = $request->input('amount');
        $recipients_name = $request->input('recipients_name');
        $recipients_phone = $request->input('recipients_phone');

        DB::beginTransaction();
        try {

            // check company and provider existence from database
            switch ($transection_type) {

                case 'receive_challan_due_from_company':
                case 'receive_demurrage_due_from_company':

                    if(TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->exists()){

                        $tripCompany = TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->first();
        
                    } else {
                        Toastr::error('', __('cmn.trip_or_company_data_not_found'));
                        return redirect()->back();
                    }

                    break;
                    
                case 'pay_due_challan_bill_to_vehicle_provider':
                case 'pay_due_demurrag_bill_to_vehicle_provider':

                    if(TripProvider::where('trip_id', $trip_id)->exists()){

                        $tripProvider = TripProvider::where('trip_id', $trip_id)->first();
        
                    } else {
                        Toastr::error('', __('cmn.trip_or_provider_data_not_found'));
                        return redirect()->back();
                    }
                    
                    break;
                
                default:
                    Toastr::error('', __('cmn.transection_type_required'));
                    return redirect()->back();
                    break;
            }

            // due amount fetch from database
            switch ($transection_type) {
                case 'receive_challan_due_from_company':
                    $due_amount = $tripCompany->due_fair;
                    break;

                case 'receive_demurrage_due_from_company':
                    $due_amount = $tripCompany->demarage_due;
                    break;

                case 'pay_due_challan_bill_to_vehicle_provider':
                    $due_amount = $tripProvider->due_fair;
                    break;

                case 'pay_due_demurrag_bill_to_vehicle_provider':
                    $due_amount = $tripProvider->demarage_due;
                    break;

                default:
                    Toastr::error('', __('cmn.transection_type_required'));
                    return redirect()->back();
                    break;
            }
            
            // if due amount 0 then return back
            if($due_amount == 0){
                Toastr::error('', __('cmn.no_due'));
                return redirect()->back();
            }
            
            // if due posting amount is greate then due amount
            if($amount > $due_amount){
                Toastr::error('',  __('cmn.the_post_amount_is_more_than_the_due_amount_so_posting_is_not_valid'));
                return redirect()->back();
            }

            // amount increase from database
            switch ($transection_type) {

                case 'receive_challan_due_from_company':
                    $left_amount = $due_amount - $amount;
                    $tripCompany->received_fair += $amount; // increase deposit
                    $tripCompany->due_fair = $left_amount; // decrease due
                    $tripCompany->save();

                    $transType = 'in';
                    $for = 'challan_bill_has_been_received_from_the_company_for_the_trip';
                    $challan_for = 'company_trip';
                    break;
                    
                case 'receive_demurrage_due_from_company':
                    $left_amount = $due_amount - $amount;
                    $tripCompany->demarage_received += $amount; // increase deposit
                    $tripCompany->demarage_due = $left_amount; // decrease due
                    $tripCompany->save();

                    $transType = 'in';
                    $for = 'demurrage_has_been_received_from_the_company_for_the_trip';
                    $challan_for = 'company_demurrage';
                    break;

                case 'pay_due_challan_bill_to_vehicle_provider':

                    $left_amount = $due_amount - $amount;
                    $tripProvider->received_fair += $amount; // increase deposit
                    $tripProvider->due_fair = $left_amount; // decrease due
                    $tripProvider->save();

                    $transType = 'out';
                    $for = 'the_vehicle_provider_has_been_paid_the_challan_due_for_the_trip';
                    $challan_for = 'provider_trip';
                    // $due_amount = $tripProvider->due_fair;

                    break;

                case 'pay_due_demurrag_bill_to_vehicle_provider':
                    $left_amount = $due_amount - $amount;
                    $tripProvider->demarage_received += $amount; // increase deposit
                    $tripProvider->demarage_due = $left_amount; // decrease due
                    $tripProvider->save();

                    $transType = 'out';
                    $for = 'the_vehicle_provider_has_been_paid_demurrage_for_the_trip';
                    $challan_for = 'provider_demarage';
                    break;

                default:
                    Toastr::error('', __('cmn.transection_type_required'));
                    return redirect()->back();
                    break;
            }

            // transection
            $trans['account_id'] = $account_id;
            $trans['amount'] = $amount;
            $trans['type'] = $transType; // in or out
            $trans['date'] = $date;
            $trans['transactionable_id'] = $trip_id;
            $trans['transactionable_type'] = 'trip';
            $trans['for'] = $for;
            $transaction = $this->transaction($trans);

            // pivot table transection
            $tripChallanModel = new TripChallan();
            $tripChallanFillData = collect($request->only($tripChallanModel->getFillable()));
            $tripChallanFinalData = $tripChallanFillData->merge(['trip_id' => $trip_id,
                                                'account_transection_id' => $transaction->id,
                                                'for'=> $challan_for])->toArray();
            $tripChallanModel->create($tripChallanFinalData);

            // account update
            $account = Account::where('id', $trans['account_id']);

            if($transType == 'in'){
                $account->increment('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);
            } else {
                $account->decrement('balance', $trans['amount'], ['updated_by'=> Auth::user()->id]);
            }
            
            DB::commit();
            Toastr::success('',__('cmn.successfully_updated_account_transactions_and_balances'));
            return redirect()->back();
        }catch (ModelNotFoundException $e) {
            DB::rollback();
            // dd($e->message());
            Toastr::error(__('cmn.sorry'), $e->message());
            return redirect()->back();
        }
    }

    public function transectionDelete($id){

        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        if (!AccountTransection::where('id', $id)->exists()) {
            Toastr::error(__('cmn.did_not_find'),__('cmn.sorry'));
            return redirect()->back();
        }

        // fetch transection data
        $accountTransection = AccountTransection::find($id);

        if ($accountTransection->transactionable_type == 'trip'){

            DB::beginTransaction();
            try {

                // dd($accountTransection); 

                $trip_id = $accountTransection->transactionable_id;
                $amount = $accountTransection->amount;

                // fetch trip info
                $trip_info = Trip::with('company')->where('id', $trip_id)->first();
                $company_id = $trip_info->company->company_id;

                // dd($accountTransection->for);

                // fetch trip company
                switch ($accountTransection->for) {

                    // for company
                    case 'challan_bill_has_been_received_from_the_company_for_the_trip':

                        $tripCompany = TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->first();
                        $tripCompany->received_fair -= $amount;// minus received  amount
                        $tripCompany->due_fair += $amount; // plus due  amount
                        $tripCompany->save();
                        break; 
                    
                    // for company
                    case 'advance_has_been_received_from_the_company_for_the_trip':

                        $tripCompany = TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->first();
                        $tripCompany->advance_fair -= $amount;// minus received  amount
                        $tripCompany->due_fair += $amount; // plus due  amount
                        $tripCompany->save();
                        break;

                    // for company
                    case 'demurrage_has_been_received_from_the_company_for_the_trip':

                        $tripCompany = TripCompany::where('trip_id', $trip_id)->where('company_id', $company_id)->first();
                        $tripCompany->demarage_received -= $amount;// minus received  amount
                        $tripCompany->demarage_due += $amount; // plus due  amount
                        $tripCompany->save();
                        break;

                    // for provider
                    case 'the_vehicle_provider_has_been_paid_the_challan_due_for_the_trip':

                        $tripProvider = TripProvider::where('trip_id', $trip_id)->first();
                        $tripProvider->received_fair -= $amount;// minus received  amount
                        $tripProvider->due_fair += $amount; // plus due  amount
                        $tripProvider->save();
                        break;
                    
                    // for provider
                    case 'the_vehicle_provider_has_been_paid_in_advance_for_the_trip':

                        $tripProvider = TripProvider::where('trip_id', $trip_id)->first();
                        $tripProvider->advance_fair -= $amount;// minus received  amount
                        $tripProvider->due_fair += $amount; // plus due  amount
                        $tripProvider->save();
                        break;

                    // for provider
                    case 'the_vehicle_provider_has_been_paid_demurrage_for_the_trip':

                        $tripProvider = TripProvider::where('trip_id', $trip_id)->first();
                        $tripProvider->demarage_received -= $amount;// minus received  amount
                        $tripProvider->demarage_due += $amount; // plus due  amount
                        $tripProvider->save();
                        break;

                }
                

                // account update
                $account = Account::whereId($accountTransection->account_id);

                // if 'in' then account amount will decrement
                if($accountTransection->type == 'in'){
                    $account->decrement('balance', $amount, ['updated_by'=> Auth::user()->id]);
                
                // if 'out' then account amount will increment
                } else {
                    $account->increment('balance', $amount, ['updated_by'=> Auth::user()->id]);
                }
                
                // delete challan
                TripChallan::where('account_transection_id', $accountTransection->id)->delete();

                // delete transection
                $accountTransection->delete();

                DB::commit();
                Toastr::success('',__('cmn.account_transactions_successfully_removed_and_balance_updated'));
                Toastr::success('',__('cmn.successfully_deleted'));
                return redirect()->back();

            } catch (\Exception $e) {
                DB::rollBack();
                Toastr::error(__('cmn.did_not_deleted'),__('cmn.sorry'));
                return redirect()->back();
            }

        } else {
            Toastr::error(__('cmn.this_is_not_trip_related_transection'),__('cmn.sorry'));
            return redirect()->back();
        }
    }
    
}