<?php

namespace App\Http\Controllers\Purchase;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Toastr;
use Carbon\Carbon;
use DB;

use App\Models\Tyres\Tyre;
use App\Models\Mobils\Mobil;
use App\Models\Purchases\Purchase;
use App\Models\Settings\SettingSupplier;
use App\Models\Settings\SettingBrand;
use App\Http\Traits\TransectionTrait;

class PurchaseController extends Controller
{
    use TransectionTrait;
    public function index(Request $request) {

        $data['request'] = $request;
        $data['top_title'] = __('cmn.purchases');
        $data['title'] = __('cmn.purchases');
        $data['menu'] = 'purchases';

        $data['sub_menu'] = 'tyre_purchase';

        $data['suppliers'] = SettingSupplier::where('type', 'goods')->orderBy('sort', 'asc')->get();
        $data['brands'] = SettingBrand::orderBy('sort', 'asc')->get();
        $data['purchases'] = Purchase::with('purchaseable','purchaseable.vehicle','purchaseable.brand')
                                    ->orderBy('date', 'desc')->Paginate(60);
        return view('purchase.purchase', $data);
    }

    public function store(Request $request)
    {
        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            // create goods record
            if($request->input('form_type') == 'tyre'){
                $tyreModel = new Tyre();
                $finalData = collect($request->only($tyreModel->getFillable()))
                                ->merge(['encrypt'=> uniqid(),'created_by'=> Auth::user()->id])
                                ->toArray();
                $tyre = $tyreModel->create($finalData);
            }elseif($request->input('form_type') == 'mobil'){
                $mobilModel = new Mobil();
                $finalData = collect($request->only($mobilModel->getFillable()))
                                    ->merge(['encrypt'=> uniqid(),'created_by'=> Auth::user()->id])
                                    ->toArray();
                $tyre = $mobilModel->create($finalData);
            } else {
                Toastr::error(__('cmn.something_went_wrong'),__('cmn.sorry'));
                return redirect()->back();
            }
            // create purchase
            $purchaseModel = new Purchase();
            $finalData = collect($request->only($purchaseModel->getFillable()))
                                ->merge([
                                    'encrypt'=> uniqid(),
                                    'purchaseable_type'=> $request->input('form_type'),
                                    'purchaseable_id'=> $tyre->id,
                                    'created_by'=> Auth::user()->id
                                ])
                                ->toArray();
            $purchase = $purchaseModel->create($finalData);
            // transection
            $trans['type'] = 'out';
            $trans['amount'] = $request->input('paid');
            $trans['method'] = 'cash';
            $trans['transactionable_id'] = $purchase->id;
            $trans['transactionable_type'] = 'purchase';
            $this->transaction($trans);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
        Toastr::success(__('cmn.successfully_added'), __('cmn.success'));
        return redirect()->back();
    }

    public function destroy($id){
        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        if (!Purchase::where('id', $id)->exists()) {
            Toastr::error(__('cmn.did_not_find'),__('cmn.sorry'));
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $purchase = Purchase::find($id);
            $purchase->transaction()->delete();
            $purchase->update(['updated_by'=> Auth::user()->id]);
            $purchase->delete();
            DB::commit();
            Toastr::success(__('cmn.successfully_deleted'),__('cmn.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('cmn.did_not_deleted'),__('cmn.sorry'));
            return redirect()->back();
        }
    }

    // public function expenseReportForm(Request $request){
    //     $data['title'] = __('cmn.expense_report_form');
    //     $data['menu'] = 'report';
    //     $data['sub_menu'] = 'expense_report';
    //     $data['request'] = $request;
    //     $data['vehicles'] = SettingVehicle::all();
    //     $data['expenses'] = SettingExpense::orderBy('sort', 'asc')->get();
    //     return view('expense.expense_report_form', $data);
    // }

    // public function expenseReport(Request $request){
    //     if(!$request->has('type')){
    //         Toastr::warning('Type not defined', 'Sorry');
    //         return redirect()->back();
    //     }
    //     $type = $request->input('type');

    //     if($type == 'general'){
    //         $title = __('cmn.expense_report');
    //     }
    //     elseif($type == 'project'){
    //         $title = __('cmn.chalan_list');
    //     }
    //     else {
    //         $title = 'undefined type';
    //     }
    //     $data['title'] =  $title;
    //     $data['menu'] = 'report';
    //     $data['sub_menu'] = 'expense_report';
    //     $data['request'] = $request;
    //     $query = Expense::with('expense');
    //     if($request->input('expense_id')){
    //         $query = $query->where('expense_id', $request->input('expense_id'));
    //     }
    //     if($request->input('vehicle_id')){
    //         $query = $query->where('vehicle_id', $request->input('vehicle_id'));
    //     }
    //     $data['lists'] = $query->orderBy('date','asc')->get();
    //     return view('expense.report.expense_report', $data);
    // }

}
