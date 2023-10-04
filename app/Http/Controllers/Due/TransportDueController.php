<?php

namespace App\Http\Controllers\Due;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\TransportDueCollection;
use App\Transport;
use Auth;
use DB;
use Toastr;

class TransportDueController extends Controller
{
    public function get_car_and_client_wise_trans_due_amount(Request $request){
    	$trans_due_trips =  Transport::where('trans_client_id', $request->client_id)
                ->where('trans_car_id', $request->car_id)
                ->where('trans_client_due_fair', '>', 0)
                ->orderBy('trans_date','asc')
                ->sum('trans_client_due_fair');

        if(empty($trans_due_trips)){
            return response()->json([ 'status'=>false, 'message'=>'Transport Due Not Found', 'data'=>[] ]);
        }
        return response()->json([ 'status'=>true, 'message'=>'Transport Due Found', 'data'=>$trans_due_trips ]);
    }

    public function transport_due_collection(Request $request){
        DB::beginTransaction();
        $uniqid = uniqid();
        $due_collection = new TransportDueCollection();
        $due_collection->encrypt = $uniqid;
        $due_collection->car_id = $request->car_id;
        $due_collection->date = $request->date;
        $due_collection->client_id  = $request->client_id;
        $due_collection->amount  = $request->amount;
        $due_collection->created_by  = Auth::user()->id;
        $due_collection->updated_by  = Auth::user()->id;
        
        $amount = $request->amount;
        $due_trans =  Transport::where('trans_client_id', $request->client_id)
                ->where('trans_car_id', $request->car_id)
                ->where('trans_client_due_fair', '>', 0)
                ->orderBy('trans_date','asc')
                ->get();
        $trans_details_array = [];
        foreach ($due_trans as   $key => $value) {
            if($value->trans_client_due_fair > $amount){
                $trans_details_array[] = [$value->trans_id, $amount];
                try {
                    $value->trans_client_due_fair = $value->trans_client_due_fair - $amount;
                    $value->save();
                } catch (ModelNotFoundException $e) {
                    DB::rollback();
                    Toastr::error('Error', $e->message());
                    return redirect()->back();
                }
                break;
            }else{
                try {
                    $amount =  $amount - $value->trans_client_due_fair;
                    $trans_details_array[] = [$value->trans_id, (int)$value->trans_client_due_fair];
                    $value->trans_client_due_fair = 0;
                    $value->save();
                } catch (ModelNotFoundException $e) {
                    DB::rollback();
                    Toastr::error('Error', $e->message());
                    return redirect()->back();
                }
            }
        } //foreach end
        //Due Colllection saved
        $due_collection->amount_history = json_encode($trans_details_array);
        try {
            $due_collection->save();
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('Error', $e->message());
            return redirect()->back();
        }

        // $acc['code'] = $uniqid;
        // $acc['table'] = $due_collection->getTable();
        // $acc['table_id'] = $due_collection->id;
        // $acc['head'] = 'due_collection';
        // $acc['cash_in'] = $request->amount;
        // try {
        //     $this->account_transaction($acc);
        // } catch (Exception $e) {
        //     DB::rollback();
        //     Toastr::error('',$e->message());
        //     return redirect()->back();
        // }
        

        //Success
        DB::commit();
        Toastr::success('Success','Successfully due collection saved');
        return redirect()->back();
    }

    public function collection_histories_delete($id){
    	DB::beginTransaction();
        $data = TransportDueCollection::findOrFail($id);
        $amount_history = json_decode($data->amount_history);
        foreach ($amount_history as $value) {
            $trans = Transport::find($value[0]);
            $trans->trans_client_due_fair += $value[1];
            try {
                $trans->save();
            } catch (Exception $e) {
                DB::rollback();
                Toastr::error('', $e->message());
                return redirect()->back();
            }
        }

        // try {
        //     $data->account->delete();
        // } catch (Exception $e) {
        //     DB::rollback();
        //     Toastr::error('', $e->message());
        //     return redirect()->back();
        // }

        // $acc['code'] = uniqid();
        // $acc['table'] = $data->getTable();
        // $acc['table_id'] = NULL;
        // $acc['head'] = 'Due collection delete adjust';
        // $acc['cash_out'] = $data->amount;
        // try {
        //     $this->account_transaction($acc);
        // } catch (Exception $e) {
        //     DB::rollback();
        //     Toastr::error('',$e->message());
        //     return redirect()->back();
        // }

        try {
            $data->delete();
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }

        DB::commit();
        Toastr::success('', 'Succes Due collection Delete');
        return redirect()->back();
    }
}
