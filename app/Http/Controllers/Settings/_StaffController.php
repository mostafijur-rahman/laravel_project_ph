<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Settings\SettingStaff;
use App\Models\Settings\SettingDesignation;
use App\Services\CommonService;

use DB;
use Auth;
use Toastr;

class StaffController extends Controller{
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
    function index(Request $request){
        // make query
        // $query = SettingStaff::leftjoin('designations','people.desig_id','=','designations.desig_id');
        // if($request->type) {
        //     $query = $query->where('people.desig_id', $request->type);
        // }
        // if($request->name_phone){
        //     $query = $query->where('people.name', 'like', '%' . $request->name_phone . '%')
        //                     ->orWhere('people.phone', 'like', '%' . $request->name_phone . '%');
        // }
        // $data['lists'] = $query->orderBy('sort', 'desc')
        //                         ->select('people.*', 'designations.desig_name')
        //                         ->paginate(50);

        $data['request'] = $request;
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.staff').' '.__('cmn.setting').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.staff').' '.__('cmn.setting').' '.__('cmn.page');
        $data['lists'] = SettingStaff::with(['designation'])->paginate(50);
        // basic data
        $data['desigs'] = SettingDesignation::all();
        $data['menu'] = 'setting';
        $data['sub_menu'] = ($request->type)?$request->type:'staff';
        return view('settings.staff.staff_list', $data);
    }
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
            'designation_id' => 'required', 
            'name' => 'required',
        ]);
        try {
            $settingStaffModel = new SettingStaff();
            $finalData = collect($request->only($settingStaffModel->getFillable()))
                                ->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id])
                                ->toArray(); 
            $tableData = $settingStaffModel->create($finalData);
            // CommonService::activity($tableData->getTable(),$tableData->id);
            Toastr::success('',__('cmn.successfully_added'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_added'));
            return redirect()->back();
        }
    }
    /**
     * show the staff
     * @author MR
     */
    function edit($id){
        if(!empty($id)){
            $data = SettingStaff::find($id);
            if(!empty($data)){
                return response(['status'=>true, 'message' => 'People Found', 'data' => $data]);
            }
        }
        return response(['status'=>false, 'message' => 'staff not Found', 'data' => []]);
    }
  
    public function update(Request $request, $id){
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        $this->validate($request,[
            'designation_id' => 'required', 
            'name' => 'required',
        ]);
        try {
            $settingStaffModel = new SettingStaff();
            $finalData = collect($request->only($settingStaffModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            $tableData = SettingStaff::find($id)->update($finalData);
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
            $staff = SettingStaff::find($id);
            $staff->update(['updated_by'=> Auth::user()->id]);
            $staff->delete();
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
        if(SettingStaff::find($request->input('id'))->update(['sort'=> $request->input('sort')])){
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back();
        } else {
            Toastr::error('',__('cmn.did_not_updated'));
            return redirect()->back();
        }
    }
  
}