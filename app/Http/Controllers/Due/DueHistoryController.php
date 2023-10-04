<?php

namespace App\Http\Controllers\Due;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Traits\AccountsTrait;
use App\Client;
use App\Account;
use App\DueCollection;
use App\Vehicle;
use App\Trip;
use Toastr;
use Auth;
use DB;

class DueHistoryController extends Controller
{
    use AccountsTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function due_histories($client_encrypt = null)
    {
        if(empty($client_encrypt)){
            Toastr::error('error','Something went wrong , please try again');
            return redirect()->back();
        }
        $data['title'] = 'Due';
        $data['menu'] = 'due';
        $data['sub_menu'] = 'installment_list';
        $data['client'] = Client::where('client_encrypt', $client_encrypt)->first();
        if(empty($data['client'])){
            Toastr::error('error','Something went wrong , please try again');
            return redirect()->back();
        }
        // $data['cars'] = Vehicle::orderBy('car_id','desc')->get();
        // $data['providers'] = SettingProvider::orderBy('id','desc')->get();
        // $data['installments'] = Installment::with('car','installment_history')->orderBy('id','desc')->get();
        return view('due.due_history', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @author SH
     Due History Collection
     * @return \Illuminate\Http\Response
     */
    public function due_collection(Request $request)
    {
        // dd($request);
        DB::beginTransaction();
        $uniqid = uniqid();
        $due_collection = new DueCollection();
        $due_collection->encrypt = $uniqid;
        $due_collection->car_id = $request->car_id;
        $due_collection->date = $request->date;
        $due_collection->client_id  = $request->client_id;
        $due_collection->amount  = $request->amount;
        $due_collection->created_by  = Auth::user()->id;
        $due_collection->updated_by  = Auth::user()->id;
        
        $amount = $request->amount;
        $due_trips =  Trip::where('trip_client_id', $request->client_id)
                ->where('trip_car_id', $request->car_id)
                ->where('trip_due_fair', '>', 0)
                ->orderBy('trip_date','asc')
                ->get();
        $trip_details_array = [];
        foreach ($due_trips as   $key => $value) {
            if($value->trip_due_fair > $amount){
                $trip_details_array[] = [$value->trip_id, $amount];
                try {
                    $value->trip_due_fair = $value->trip_due_fair - $amount;
                    $value->save();
                } catch (ModelNotFoundException $e) {
                    DB::rollback();
                    Toastr::error('Error', $e->message());
                    return redirect()->back();
                }
                break;
            }else{
                try {
                    $amount =  $amount - $value->trip_due_fair;
                    $trip_details_array[] = [$value->trip_id, (int)$value->trip_due_fair];
                    $value->trip_due_fair = 0;
                    $value->save();
                } catch (ModelNotFoundException $e) {
                    DB::rollback();
                    Toastr::error('Error', $e->message());
                    return redirect()->back();
                }
            }
        } //foreach end
        //Due Colllection saved
        $due_collection->amount_history = json_encode($trip_details_array);
        try {
            $due_collection->save();
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('Error', $e->message());
            return redirect()->back();
        }

        $acc['code'] = $uniqid;
        $acc['table'] = $due_collection->getTable();
        $acc['table_id'] = $due_collection->id;
        $acc['head'] = 'due_collection';
        $acc['cash_in'] = $request->amount;
        try {
            $this->account_transaction($acc);
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
        


        //Success
        DB::commit();
        Toastr::success('Success','Successfully due collection saved');
        return redirect()->back();
    }

    /**
     * Show the form for creating a new resource.
     * @author SH
     Due History Collection
     * @return \Illuminate\Http\Response
     */
    public function collecction_histroy($client_encrypt = null)
    {
        if(empty($client_encrypt)){
            Toastr::error('error','Something went wrong , please try again');
            return redirect()->back();
        }
        $data['title'] = 'Collection History';
        $data['menu'] = 'due';
        $data['client'] = Client::where('client_encrypt', $client_encrypt)->first();
        $data['cars'] = Vehicle::all();
        if(empty($data['client'])){
            Toastr::error('error','Something went wrong , please try again');
            return redirect()->back();
        }
        return view('due.collection_history', $data);
    }


    /**
     * @author SH
        Due History Collection Delete
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        DB::beginTransaction();
        $data = DueCollection::findOrFail($id);
        $amount_history = json_decode($data->amount_history);
        foreach ($amount_history as $value) {
            $trips = Trip::find($value[0]);
            $trips->trip_due_fair += $value[1];
            try {
                $trips->save();
            } catch (Exception $e) {
                DB::rollback();
                Toastr::error('', $e->message());
                return redirect()->back();
            }
        }

        try {
            $data->account->delete();
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('', $e->message());
            return redirect()->back();
        }

        $acc['code'] = uniqid();
        $acc['table'] = $data->getTable();
        $acc['table_id'] = NULL;
        $acc['head'] = 'Due collection delete adjust';
        $acc['cash_out'] = $data->amount;
        try {
            $this->account_transaction($acc);
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }

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

    public function get_car_and_client_wise_due_amount(Request $request){
        $due_trips =  Trip::where('trip_client_id', $request->client_id)
                ->where('trip_car_id', $request->car_id)
                ->where('trip_due_fair', '>', 0)
                ->orderBy('trip_date','asc')
                ->sum('trip_due_fair');

        if(empty($due_trips)){
            return response()->json([ 'status'=>false, 'message'=>'Due Not Found', 'data'=>[] ]);
        }
        return response()->json([ 'status'=>true, 'message'=>'Due Found', 'data'=>$due_trips ]);
    }

}


