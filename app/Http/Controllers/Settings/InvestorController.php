<?php

namespace App\Http\Controllers\Settings;

use App\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingSupplier;
use App\Models\Settings\SettingStaff;
use App\Models\Settings\SettingDivision;
use App\Models\Settings\SettingBrand;
use App\Models\Settings\SettingInvestor;
use App\Services\CommonService;
use DB;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Toastr;

class investorController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {  
          
        $data['request'] = $request;
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.investor').' '.__('cmn.setting').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.investor').' '.__('cmn.setting').' '.__('cmn.page');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'investor_list';
        $data['lists'] = SettingInvestor::orderBy('sort','asc')->Paginate(50);
        return view('settings.investor', $data);
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
            $settingBrandModel = new SettingInvestor();
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
            $settingBrandModel = new SettingInvestor();
            $finalData = collect($request->only($settingBrandModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            $settingInvestor = SettingInvestor::find($id);
            $settingInvestor->update($finalData);
            // CommonService::activity($tableData->getTable(),$tableData->id,'updated_this_item');
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
            $brand = SettingInvestor::find($id);
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
        if(SettingBrand::find($request->input('id'))->update(['sort'=> $request->input('sort')])){
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back();
        } else {
            Toastr::error('',__('cmn.did_not_updated'));
            return redirect()->back();
        }
    }


}