<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Loan;
use App\Client;


use Carbon\Carbon;
use Auth;
use Toastr;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $data['menu'] = 'loan';
        $data['title'] = 'Loan';
        $data['lists'] = Loan::orderBy('date','desc')->paginate(50);
        $data['clients'] = Client::orderBy('client_sort','asc')->get();
        return view('loan.loan', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'date' => "required",
            'client' => "required",
            'trans' => "required",
            'amount' => "required",
        ]);
        $ls_bl = $this->get_last_balance();
        $cash_in = ($request->trans == 'cash_in') ? $request->amount : null;
        $cash_out= ($request->trans == 'cash_out') ? $request->amount : null;
        // insertion
        $data = new Loan();
        $data->date =  $request->date;
        $data->client_id =  $request->client;
        $data->cash_in = $cash_in;
        $data->cash_out = $cash_out;
        $data->balance = ($cash_in) ? $ls_bl + $cash_in : $ls_bl - $cash_out;
        $data->note = $request->note;
        $data->created_by = Auth::user()->id;
        if($data->save()){
            Toastr::success('Successfully Saved', 'Success');
            return redirect()->back();
        } else{
            Toastr::error($e->getMessage(), 'Sorry! Something wrong', 'Warning');
            return redirect()->back();
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
        $data = Transection::where('id', $id)->first();
        if($data->delete()){
            Toastr::success('Successfully Deleted!', 'Success');
            return redirect()->back();
        } else{
            Toastr::error('Did Not Updated', 'Sorry');
            return redirect()->back();
        }
    }
    /**
     * get last balance of accounts table
     *
     * @return get last balance
     */
	public function get_last_balance(){
		$last_balance = Loan::select('balance')->orderBy('created_at','desc')->first();
		if($last_balance){
			return $last_balance->balance;
		} else {
			return 0;
		}
    }

}
