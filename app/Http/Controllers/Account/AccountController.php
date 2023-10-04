<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Request
use App\Http\Requests\Account\AccountRequest;
use App\Http\Requests\Account\AccountUpdateRequest;

// Models
use App\Models\Accounts\Account;
use App\Models\Accounts\AccountTransection;
use App\Models\Settings\SettingBank;
use App\Services\CommonService;
use App\User;

use Auth;
use Toastr;
use PDF;
use Carbon\Carbon;

class AccountController extends Controller
{
    public function index(Request $request){

        $data['request'] = $request;
        $data['banks'] = SettingBank::all();
        $data['users'] = User::get();
        $data['menu'] = 'accounts';

        if($request->input('page_name') == 'create_bank' || $request->input('page_name') == 'create_cash'){
            $data['top_title'] = __('cmn.account_list');
            $data['title'] = __('cmn.account_list');
            $data['sub_menu'] = 'account_list';
            $data['lists'] = Account::orderBy('id','desc')->paginate(50);
            if($request->has('id')){
                $data['info'] = Account::where('id', $request->input('id'))->first();
            }
            return view('account.account', $data);
        }

        if($request->input('page_name') == 'reports'){
            $data['top_title'] = __('cmn.transection').' '.__('cmn.report');
            $data['title'] = __('cmn.transection').' '.__('cmn.report');
            $data['sub_menu'] = 'report';
            $data['vehicles'] = [];
            $data['accounts'] = Account::orderBy('id','desc')->paginate(50);
            return view('account.report_form', $data);
        }
    }

    public function store(AccountRequest $request){

        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        try {
            $model = new Account();
            $finalData = collect($request->only($model->getFillable()))
                            ->merge(['encrypt'=> uniqid(), 'balance'=>0, 'created_by'=> Auth::user()->id])
                            ->toArray();
            Account::create($finalData);
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error('',$e->message());
            return redirect()->back();
        }        

    }

    public function update(AccountUpdateRequest $request, $id){

        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        try{
            $AccountModel = new Account();
            $finalData = collect($request->only($AccountModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            Account::find($id)->update($finalData);
            Toastr::success('',__('cmn.successfully_updated'));

            $page = ($request->input('type')=='bank')?'create_bank':'create_cash';
            return redirect('accounts?page_name='.$page); 

        }catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_updated'));
            return redirect()->back();
        }
    }
    
    public function destroy($id){
        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        if (!Account::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }
        try {

            $exists =  AccountTransection::where('account_id', $id)
                                            ->whereNull('deleted_at')
                                            ->exists();
            if(!$exists){
                $account = Account::find($id);
                $account->update(['updated_by'=> Auth::user()->id]);
                $account->delete();
                Toastr::success('',__('cmn.successfully_deleted'));
            } else {
                Toastr::error('',__('cmn.there_are_transactions_in_this_account_so_the_account_cannot_be_deleted'));
            }
            return redirect()->back();
        }catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    } 

    public function report(Request $request)
    {
        ini_set('max_execution_time', '600'); // 10 minutes
        ini_set("pcre.backtrack_limit", "5000000");

        $data['reporting_time'] = date('d M, Y h:i:s a');
        $data['title'] = __('cmn.transection') .' '.__('cmn.report');
        $data['menu'] = 'accounts';
        $data['sub_menu'] = 'report';
        $data['car_number'] = null;
        $data['request'] = $request;
        $data['page_header'] = $request->input('page_header');
        
        $date_range_status = $request->input('date_range_status');
        $month = $request->input('month');
        $year = $request->input('year');
        $expense_id =  $request->input('expense_id');
        $vehicle_id = $request->input('vehicle_id');
        $date_range_status = $request->input('date_range_status');
        $daterange = $request->input('daterange');
        // query
        $query = AccountTransection::with('account');
        if($request->input('account_id')){
            $query = $query->where('account_id', $request->input('account_id'));
        }
        if($request->input('bank_id')){
            $query = $query->whereHas('account', function($subQuery) use($request) {
                $subQuery->where('bank_id', $request->input('bank_id'));  
           });
        }
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
        if($date_range_status == 'yearly_report'){
            if(!$year){
                Toastr::error(__('cmn.please_select_year_first'), __('cmn.warning'));
                return redirect()->back();
            }
            $data['title'] .= ' - (' . __('cmn.year') .'- ' .__('cmn.'.$year.''). ')';
            $query = $query->whereYear('date',$year);
        }

        if($date_range_status == 'date_wise' && $daterange){
            
            $date = explode(' - ', $daterange);
            $start_date = Carbon::parse($date[0])->startOfDay();
            $end_date = Carbon::parse($date[1])->endOfDay();
            $data['title'] .= ' - '  . __('cmn.date') .' - (' . Carbon::parse($date[0])->format('d F, Y') .' ' .__('cmn.from'). ' '. Carbon::parse($date[1])->format('d F, Y') . ')';
            
            $query = $query->whereBetween('date', [$start_date, $end_date]);
        }
        $data['lists'] = $query->orderBy('date','ASC')->get();

        // $pdf = PDF::loadView('account.report.transection_pdf', $data);

        // assign page config
        $config['format'] = $request->input('size');
        $pdf = PDF::loadView('account.report.transection_pdf', $data, [], $config);

        if($request->input('download_pdf') == 'true'){
            return $pdf->download($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        } else {
            return $pdf->stream($data['title'] .' ('. __('cmn.reporting_time'). ' - '. $data['reporting_time'] .')'. '.pdf');
        }

    }
  
    
}
