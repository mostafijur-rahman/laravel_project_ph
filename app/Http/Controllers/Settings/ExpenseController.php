<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\SettingExpense;
use App\Services\CommonService;


use Auth;
use Toastr;

class ExpenseController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.expense').' '.__('cmn.setting').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.expense').' '.__('cmn.setting').' '.__('cmn.page');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'general_expense';
        $query = SettingExpense::query();
        if($request->head){
            $query = $query->where('head', 'like', '%' . $request->head . '%');
        }
        $data['lists'] = $query->orderBy('sort', 'asc')->paginate(50);
        $data['request'] = $request;
        return view('settings.expense', $data);
    }

    public function store(Request $request)
    {
        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        $this->validate($request,[
            'head' => 'required',
        ]);
        try {
            $SettingExpenseModel = new SettingExpense();
            $finalData = collect($request->only($SettingExpenseModel->getFillable()))
                            ->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id])
                            ->toArray(); 
            $tableData = $SettingExpenseModel->create($finalData);
            // CommonService::activity($tableData->getTable(),$tableData->id,'created_this_item');
            Toastr::success('',__('cmn.successfully_added'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_added'));
            return redirect()->back();
        }
    }
 
    public function update(Request $request, $id)
    {
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        $this->validate($request,[
            'head' => 'required',
        ]);
        try {
            $SettingExpenseModel = new SettingExpense();
            $finalData = collect($request->only($SettingExpenseModel->getFillable()))
            ->merge(['updated_by'=> Auth::user()->id])
            ->toArray();
            $tableData = SettingExpense::find($id)->update($finalData);
            // CommonService::activity($tableData->getTable(),$tableData->id);
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_updated'));
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
       
        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        try {
            $expense = SettingExpense::find($id);
            $expense->update(['updated_by'=> Auth::user()->id]);
            $expense->delete();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }
 
    // public function sort_update(Request $request){
    //     $this->validate($request,[
    //         'sort' => 'required', 
    //         'id' => 'required',
    //     ]);
    //     if(SettingExpense::find($request->input('id'))->update(['sort'=> $request->input('sort')])){
    //         Toastr::success('',__('cmn.successfully_updated'));
    //         return redirect()->back();
    //     } else {
    //         Toastr::error('',__('cmn.did_not_updated'));
    //         return redirect()->back();
    //     }
    // }

    public function sort_update(Request $request)
    {
        $models = SettingExpense::all();

        foreach ($models as $model) {
            foreach ($request->order as $order) {
                if ($order['id'] == $model->id) {
                    $model->update(['sort' => $order['position']]);
                }
            }
        }
        
        return response(__('cmn.successfully_updated'), 200);
    }
}
