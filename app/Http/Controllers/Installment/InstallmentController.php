<?php

namespace App\Http\Controllers\Installment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Installment;
use App\SettingProvider;
use App\InstallmentHistory;
use App\Http\Traits\AccountsTrait;
use App\Vehicle;
use App\Account;
use Auth;
use DB;
use Toastr;
use Carbon\Carbon;

class InstallmentController extends Controller
{

    use AccountsTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Installment';
        $data['menu'] = 'installment';
        $data['cars'] = Vehicle::orderBy('car_id','desc')->get();
        $data['providers'] = SettingProvider::orderBy('id','desc')->get();
        $data['installments'] = Installment::with('car','installment_history')->orderBy('id','desc')->get();
        $data['sub_menu'] = 'installment_list';
        
        // $data['lists'] = ;
        return view('installment.installment', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       $data['title'] = 'Installment';
        $data['menu'] = 'installment';
        $data['sub_menu'] = 'installment_create';
        
       return view('installment.installment_create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //trasaction start
        DB::beginTransaction();
        $uniqid = uniqid();

        $install_data = new Installment();
        $install_pay_date = explode(' - ',$request->install_pay_date);
        $install_data->code = $uniqid;
        $install_data->buy_date = $request->buy_date;
        $install_data->providers_id = $request->providers_id;
        $install_data->car_id  = $request->car_id ;
        $install_data->chassis_price = $request->chassis_price;
        $install_data->interest_percent  = $request->interest_percent    ;
        $install_data->discount = $request->discount;
        $install_data->total_price = $request->total_price;
        $install_data->down_payment = $request->down_payment;
        $install_data->install_number = $request->install_number;
        $install_data->install_amount = $request->install_amount;
        $install_data->install_pay_start_date  = (isset($install_pay_date[0])) ? Carbon::parse($install_pay_date[0])->format('Y-m-d') : date('Y-m-d');
        $install_data->install_pay_end_date = (isset($install_pay_date[1])) ? Carbon::parse($install_pay_date[0])->format('Y-m-d') : date('Y-m-d');
        $install_data->created_by = Auth::user()->id;
        $install_data->updated_by = Auth::user()->id;
        $install_data->created_at = Carbon::now();
        try {
            $install_data->save();
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }

        $installment_history = new InstallmentHistory();
        $installment_history->code = $uniqid;
        $installment_history->install_id = $install_data->id;
        $installment_history->pay_date = $request->buy_date;
        $installment_history->pay_type = 2;
        $installment_history->pay_amount = $request->down_payment;
        $installment_history->created_by = Auth::user()->id;
        $installment_history->updated_by = Auth::user()->id;
        $installment_history->created_at = Carbon::now();
        //installment history added
        try {
            $installment_history->save();
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }

        $acc['code'] = $uniqid;
        $acc['table'] = $installment_history->getTable();
        $acc['table_id'] = $installment_history->id;
        $acc['head'] = 'installment_car_buying';
        $acc['cash_out'] = $request->down_payment;
        try {
            $this->account_transaction($acc);
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }

        //db transaction end
        DB::commit();
        Toastr::success('','Successfully Data saved');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!empty($id)){
            $data = Installment::find($id);
            $data['pay_date'] = Carbon::parse($data->install_pay_start_date)->format('m/d/Y').' - '.Carbon::parse($data->install_pay_start_date)->format('m/d/Y');
            if(!empty($data)){
                return response(['status'=>true, 'message' => 'Installment Found', 'data' => $data]);
            }
        }
        return response(['status'=>false, 'message' => 'Installment not Found', 'data' => []]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request){
        // dd($request);
        //trasaction start
        DB::beginTransaction();
        $install_data = Installment::where('code',$request->installment_code)->first();
        $install_pay_date = explode(' - ',$request->install_pay_date);
        $install_data->buy_date = $request->buy_date;
        $install_data->providers_id = $request->providers_id;
        $install_data->car_id  = $request->car_id ;
        $install_data->chassis_price = $request->chassis_price;
        $install_data->interest_percent  = $request->interest_percent    ;
        $install_data->discount = $request->discount;
        $install_data->total_price = $request->total_price;
        $install_data->down_payment = $request->down_payment;
        $install_data->install_number = $request->install_number;
        $install_data->install_amount = $request->install_amount;
        $install_data->install_pay_start_date  = (isset($install_pay_date[0])) ? Carbon::parse($install_pay_date[0])->format('Y-m-d') : date('Y-m-d');
        $install_data->install_pay_end_date = (isset($install_pay_date[1])) ? Carbon::parse($install_pay_date[0])->format('Y-m-d') : date('Y-m-d');
        $install_data->updated_at = Carbon::now();
        try {
            $install_data->save();
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }

        $installment_history = InstallmentHistory::where('code',$request->installment_code)->first();
        $installment_history->install_id = $install_data->id;
        $installment_history->pay_date = $request->buy_date;
        $installment_history->pay_type = 2;
        $installment_history->pay_amount = $request->down_payment;
        $installment_history->created_by = Auth::user()->id;
        $installment_history->updated_by = Auth::user()->id;
        $installment_history->created_at = Carbon::now();
        //installment history added
        try {
            $installment_history->save();
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }

        
        if($request->down_payment != $install_data->down_payment){
            $account_data = Account::where('code',$request->code)->first();
            $cash_out_data = $account_data->cash_out;
            $last_balance_get = Account::select('balance')->orderBy('id','desc')->first();
            $last_balance_get->balance = $last_balance_get->balance + $cash_out_data;
            try {
                $last_balance_get->save();
                $account_data->delete();
            } catch (ModelNotFoundException $e) {
                DB::rollback();
                Toastr::error('',$e->message());
                return redirect()->back();
            }

            $acc['code'] = $request->code;
            $acc['table'] = $installment_history->getTable();
            $acc['table_id'] = $installment_history->id;
            $acc['head'] = 'installment_car_buying';
            $acc['cash_out'] = $request->down_payment;
            try {
                $this->account_transaction($acc);
            } catch (Exception $e) {
                DB::rollback();
                Toastr::error('',$e->message());
                return redirect()->back();
            }

        }
        
        //db transaction end
        DB::commit();
        Toastr::success('','Successfully Data saved');
        return redirect()->back();
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Installment $installment)
    {
        if(empty($installment)){
            Toastr::error('','Installment Not Found');
            return redirect()->back();
        }
        DB::beginTransaction();

        try {
            $installment->delete();
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('', $e->message());
            return redirect()->back();
        }

        try {
            $installment->Installment_down_payment->delete();
        } catch (Exception $e) {
            DB::rollback();
            Toastr::error('', $e->message());
            return redirect()->back();
        }

        //db transaction end
        DB::commit();
        Toastr::success('','Successfully Data Delete');
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function installment_history($code)
    {
        $data['title'] = 'Installment';
        $data['menu'] = 'installment';
        $data['sub_menu'] = 'installment_list';
        $data['installment'] = Installment::with('car','installment_history')->orderBy('id','desc')->where('code', $code)->first();
        return view('installment.installment_history', $data);
    }

    public function installment_collection(Request $request){
        DB::beginTransaction();
        for ($i=0; $i < count($request->installment_amount); $i++) { 
            $installment_history = new InstallmentHistory();
            $installment_history->code = uniqid();
            $installment_history->install_id = $request->installment_history_code;
            $installment_history->pay_date = $request->date[$i];
            $installment_history->pay_type = $request->pay_type[$i];
            $installment_history->install_no = $request->installment_number[$i];
            $installment_history->pay_amount = $request->installment_amount[$i];
            $installment_history->created_by = Auth::user()->id;
            $installment_history->updated_by = Auth::user()->id;
            $installment_history->created_at = Carbon::now();
            //installment history added
            try {
                $installment_history->save();
            } catch (ModelNotFoundException $e) {
                DB::rollback();
                Toastr::error('',$e->message());
                return redirect()->back();
            }

            $acc['code'] = $installment_history->code;
            $acc['table'] = $installment_history->getTable();
            $acc['table_id'] = $installment_history->id;
            $acc['head'] = 'installment_car_buying';
            $acc['cash_out'] = $request->installment_amount[$i];
            try {
                $this->account_transaction($acc);
            } catch (Exception $e) {
                DB::rollback();
                Toastr::error('',$e->message());
                return redirect()->back();
            }

        }

        //db transaction end
        DB::commit();
        Toastr::success('','Successfully Data saved');
        return redirect()->back();
    }


    //Installment History Delete
    public function installment_history_delete($code){
        DB::beginTransaction();
        $installment_history =  InstallmentHistory::where('code', $code)->first();
        //account table update
        $account_data = Account::where('code',$code)->first();
        $previous_cash = $account_data->cash_out;
        $last_balance_get = Account::select('balance')->orderBy('id','desc')->first();
        $last_balance_get->balance = $last_balance_get->balance + $previous_cash;
        try {
            $last_balance_get->save();
            $account_data->delete();
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
        
        try {
            $installment_history->delete();
        } catch (ModelNotFoundException $e) {
            DB::rollback();
            Toastr::error('',$e->message());
            return redirect()->back();
        }

        //db transaction end
        DB::commit();
        Toastr::success('','Successfully Data saved');
        return redirect()->back();

    }

    
}
