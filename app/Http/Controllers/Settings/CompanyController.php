<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\SettingCompany;
use App\Services\CommonService;
use DB;
use Auth;
use Toastr;

class CompanyController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    // function index(Request $request){
    //     $data['top_title'] = __('cmn.company').' '.__('cmn.setting');
    //     $data['title'] = __('cmn.company').' '.__('cmn.setting');
    //     $data['menu'] = 'setting';
    //     $data['sub_menu'] = 'company_list';
    //     $data['request'] = $request;
    //     $query = SettingCompany::query();
    //     if($request->name_phone){
    //         $query = $query->where('name', 'like', '%' . $request->name_phone . '%')
    //                     ->orWhere('phone', 'like', '%' . $request->name_phone . '%');
    //     }
    //     $data['lists'] = $query->orderBy('sort', 'asc')->paginate(50);
    //     return view('settings.company.company_list', $data);
    // }
    /**
     *  people data add
     * @author MR
     */
    function store(Request $request){
        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        $this->validate($request,[
            'name' => 'required',
        ]);
        try {
            $settingCompanyModel = new SettingCompany();
            $finalData = collect($request->only($settingCompanyModel->getFillable()))
                            ->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id])
                            ->toArray(); 
            $settingCompanyModel->create($finalData);
            // CommonService::activity($tableData->getTable(),$tableData->id);
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_posted'));
            return redirect()->back();
        }
    }
    /**
     * update a  resource in storage.
     * @author MR
     */
    public function update(Request $request, $id){
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        $this->validate($request,[
            'name' => 'required',
        ]);
        try {
            $settingCompanyModel = new SettingCompany();
            $finalData = collect($request->only($settingCompanyModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            $tableData = SettingCompany::find($id)->update($finalData);
            // CommonService::activity($tableData->getTable(),$tableData->id);
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back(); 
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
        try {
            $company = SettingCompany::find($id);
            $company->update(['updated_by'=> Auth::user()->id]);
            $company->delete();
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
        if(SettingCompany::find($request->input('id'))->update(['sort'=> $request->input('sort'), 'updated_by'=> Auth::user()->id])){
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back();
        } else {
            Toastr::error('',__('cmn.did_not_updated'));
            return redirect()->back();
        }
    }
}