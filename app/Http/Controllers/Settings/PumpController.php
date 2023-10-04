<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Settings\SettingPump;
use App\Services\CommonService;
use App\Designation;

use DB;
use Auth;
use Toastr;

class PumpController extends Controller {
    /** 
     * construct of this class
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * show the people list
     * @author MR
     */
    // function index(Request $request){
    //     $data['request'] = $request;
    //     $query = SettingPump::query();
    //     if($request->name){
    //         $query=$query->where('name', 'like', '%' . $request->name . '%');
    //     }
    //     $data['lists'] = $query->paginate(50);
    //     $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.pump').' '.__('cmn.setting').' '.__('cmn.page');
    //     $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.pump').' '.__('cmn.setting').' '.__('cmn.page');
    //     $data['menu'] = 'setting';
    //     $data['sub_menu'] = 'pump_list';
    //     return view('settings.pump.pump_list', $data);
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
        $this->validate($request, [
            'name' => 'required',
        ]);
        try {
            $settingPumpModel = new SettingPump();
            $finalData = collect($request->only($settingPumpModel->getFillable()))
                                ->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id])
                                ->toArray(); 
            $tableData = $settingPumpModel->create($finalData);
            // CommonService::activity($tableData->getTable(),$tableData->id);
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_posted'));
            return redirect()->back();
        }
    }
    /**
     * show the people edit form
     * @author MR
     */
    function edit($id){
        if(!empty($id)){
            $data = SettingPump::find($id);
            if(!empty($data)){
                return response(['status'=>true, 'message' => 'Vehicle Found', 'data' => $data]);
            }
        }
        return response(['status'=>false, 'message' => 'Vehicle not Found', 'data' => []]);
    }
  
    public function update(Request $request, $id){
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        $this->validate($request,[
            'name' => 'required',
        ]);
        try {
            $settingPumpModel = new SettingPump();
            $finalData = collect($request->only($settingPumpModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            $tableData = SettingPump::find($id)->update($finalData);
            // CommonService::activity($tableData->getTable(),$tableData->id);
            Toastr::success(__('cmn.successfully_updated'),__('cmn.success'));
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
            $pump = SettingPump::find($id);
            $pump->update(['updated_by'=> Auth::user()->id]);
            $pump->delete();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }
    /**
     * update a  resource in storage.
     * @author MR
     */
    public function sort_update(Request $request){
        $this->validate($request,[
            'sort' => 'required', 
            'id' => 'required',
        ]);
        if(SettingPump::find($request->input('id'))->update(['sort'=> $request->input('sort')])){
            Toastr::success(__('cmn.successfully_updated'),__('cmn.success'));
            return redirect()->back();
        } else {
            Toastr::error('',__('cmn.did_not_updated'));
            return redirect()->back();
        }
    }
}
