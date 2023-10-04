<?php

namespace App\Http\Controllers\Capital;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Traits\AccountsTrait;
use App\Models\CapitalHistory;
use App\Models\Capital;
use App\Models\Investor;
use App\Vehicle;
use Toastr;
use Auth;
use DB;

class CapitalController extends Controller
{
    use AccountsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(request $request)
    {
        $data['title'] = 'Capital';
        $data['menu'] = 'capitals';
        $data['sub_menu'] = 'capitals';
        $data['request'] = $request;
        $data['capitals'] = Capital::orderBy('id','desc')->paginate(50);
        $data['investors'] = Investor::orderBy('sort','asc')->paginate(50);
        $data['cars'] = Vehicle::all();
        return view('capitals.capitals', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        $acc = array();
        $data = new Capital();
        $data->code = uniqid();
        $data->car_id = $request->car_id;
        $data->date = $request->date;
        $data->head = $request->head;
        $data->note = $request->note;
        if($request->type == 1){
            $acc['head'] = 'capital in';
            $acc['cash_in'] = $request->amount;
            $data->cash_in = $request->amount;
            $data->balance = $this->last_balance_get() + ($request->amount)?: 0;
        }
        if($request->type == 2){
            $acc['head'] = 'capital out';
            $acc['cash_out'] = $request->amount;
            $data->cash_out = $request->amount;
            $data->balance = $this->last_balance_get() - ($request->amount)?: 0;
        }
        $data->created_by = Auth::user()->id;
        try {
            $data->save();
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('', $e->message());
            return redirect()->back();
        }

        $acc['code'] = $data->code;
        $acc['table'] = $data->getTable();
        $acc['table_id'] = $data->id;
        try {
            $this->account_transaction($acc);
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
        DB::commit();
        Toastr::success('','Successfully Data Saved');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function last_balance_get()
    {
        $last_balance_get = Capital::orderBy('id','desc')->first();
        if($last_balance_get){
            return $last_balance_get->balance;
        }else{
            return 0;
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        DB::beginTransaction();

        $capitals_history = CapitalHistory::findOrFail($id);

        $cap_data = Capital::findOrFail($capitals_history->capital_id);

        if($capitals_history->cash_in){
            $cap_data->balance -= $capitals_history->cash_in;
        }elseif($capitals_history->cash_out){
            $cap_data->balance += $capitals_history->cash_out;
        }else{
            Toastr::warning('','Something went wrong, please try again later');
            return redirect()->back();
        }

        try {
            $cap_data->save();
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }

        try {
            $capitals_history->delete();
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }

        DB::commit();
        Toastr::success('','Successfully Capital History Deleted');
        return redirect()->back();


        // $acc = array();
        // if(!empty($capital->cash_in)){
        //     $acc['head'] = 'capital in delete';
        //     $acc['cash_out'] = $capital->cash_in;
        // }
        // if(!empty($capital->cash_out)){
        //     $acc['head'] = 'capital out delete';
        //     $acc['cash_in'] = $capital->cash_out;
        // }
      
        // $acc['code'] = uniqid();
        // $acc['table'] = $capital->getTable();
        // $acc['table_id'] = $capital->id;
        // try {
        //     $this->account_transaction($acc);
        // } catch (Exception $e) {
        //     DB::rollback();
        //     Toastr::error('',$e->message());
        //     return redirect()->back();
        // }

        // try {
        //     $capital->account->delete();
        // } catch (Exception $e) {
        //     DB::rollback();
        //     Toastr::error('',$e->message());
        //     return redirect()->back();
        // }

        // try {
        //     $capital->delete();
        // } catch (Exception $e) {
        //     DB::rollback();
        //     Toastr::error('',$e->message());
        //     return redirect()->back();
        // }

        // DB::commit();
        // Toastr::success('','Successfully Data Delete');
        // return redirect()->back();
    }


    public function capitals_history($code){
        $data['menu'] = 'capitals';
        $data['sub_menu'] = 'capitals';
        $data['title'] = "Capital History";
        $data['cars'] = Vehicle::all();
        $investor = Investor::where('encrypt', $code)->first();
        if(empty($investor)){
            Toastr::error('', 'Invest Data Not Found');
            return redirect()->back();
        }
        $data['investors'] = $investor;
        return view('capitals.capitals_history', $data);
    }


    public function capitals_history_store(Request $request){
        DB::beginTransaction();
        $investor = Investor::where('encrypt', $request->inv_code)->first();
        if(empty($investor)){
            Toastr::error('', 'Invest Data Not Found');
            return redirect()->back();
        }
        $capitals = Capital::where('business_type', $request->business_type)->where('invenstor_id', $investor->id)->first();
        if(empty($capitals)){
            $capitals = new Capital();
            $capitals->balance = $request->amount;
        }else{
            if($request->cash_type == 1){
                $capitals->balance += $request->amount;
            }else{
                $capitals->balance -= $request->amount;
            }
        }
        $capitals->code = uniqid();
        $capitals->invenstor_id = $investor->id;
        $capitals->business_type = $request->business_type;
        $capitals->note = $request->note;
        $capitals->created_by = Auth::user()->id;
        $capitals->updated_by = Auth::user()->id;

        try {
            $capitals->save();
        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error('', $e->message());
            return redirect()->back();
        }
        $capitals_history = new CapitalHistory();
        $capitals_history->code = uniqid();
        $capitals_history->date = $request->date;
        $capitals_history->capital_id = $capitals->id;
        $capitals_history->business_type = $request->business_type;
        $capitals_history->vehicle_id = $request->car;
        if($request->cash_type == 1){
            $capitals_history->cash_in = $request->amount;
        }else{
            $capitals_history->cash_out = $request->amount;
        }
        $capitals_history->note = $request->note;
        $capitals_history->created_by = Auth::user()->id;
        $capitals_history->updated_by = Auth::user()->id;

        try {
            $capitals_history->save();
        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error('', $e->message());
            return redirect()->back();
        }
        DB::commit();
        Toastr::success('', 'Capital Store Successfully');
        return redirect()->back();
    }

    public function capitals_history_update(Request $request){
        if(!$request->id){
            Toastr::error('আপডেট হতে পারিনি!', 'সফল');
            return redirect()->back();   
        }
        $capitals_history = CapitalHistory::where('id', $request->id)->first();
        $capitals_history->note = $request->note;
        $capitals_history->updated_by = Auth::user()->id;
        if($capitals_history->save()){
            Toastr::success('আপডেট হয়েছে!', 'সফল');
            return redirect()->back();
        } else {
            Toastr::error('আপডেট হতে পারিনি!', 'দুঃখিত');
            return redirect()->back();
        }
    }

}
