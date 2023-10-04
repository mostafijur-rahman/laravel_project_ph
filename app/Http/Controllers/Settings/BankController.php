<?php

namespace App\Http\Controllers\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\CommonService;
use App\Models\Settings\SettingBank;

use DB;
use Auth;
use Toastr;

class bankController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {  
          
        $data['request'] = $request;
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.bank').' '.__('cmn.setting').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.bank').' '.__('cmn.setting').' '.__('cmn.page');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'bank';
        $data['lists'] = SettingBank::orderBy('sort','asc')->Paginate(50);
        return view('settings.bank', $data);
    }

    public function store(Request $request)
    {
        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
       $this->validate($request,[
            'name' => 'required',
        ]);
        try {
            $settingBrandModel = new SettingBank();
            $finalData = collect($request->only($settingBrandModel->getFillable()))
                                ->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id])
                                ->toArray(); 
            $tableData = $settingBrandModel->create($finalData);
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
            'name' => 'required'
        ]);
        try{
            $settingBrandModel = new SettingBank();
            $finalData = collect($request->only($settingBrandModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            $tableData = SettingBank::find($id)->update($finalData);
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
            $brand = SettingBank::find($id);
            $brand->update(['updated_by'=> Auth::user()->id]);
            $brand->delete();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }

    public function sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);
        if(SettingBank::find($request->input('id'))->update(['sort'=> $request->input('sort')])){
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back();
        } else {
            Toastr::error('',__('cmn.did_not_updated'));
            return redirect()->back();
        }
    }


}