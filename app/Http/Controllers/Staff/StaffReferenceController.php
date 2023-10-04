<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Settings\SettingStaff;
use App\Models\Settings\SettingStaffReference;

use Auth;
use Toastr;
use Carbon\Carbon;
use DB;

class StaffReferenceController extends Controller
{

    public function index(Request $request, $staff_id)
    {   

        if(SettingStaff::where('id', $staff_id)->exists()){
            $staff = SettingStaff::where('id', $staff_id)->first();
            $data['staff_name'] = $staff->name;
        } else {
            Toastr::error('',__('cmn.did_not_found'));
            return redirect()->back();
        }

        $data['request'] = $request;
        $data['menu'] = 'staff';
        $data['sub_menu'] = 'list';
        $data['staff_id'] = $staff_id;
        
        $data['top_title'] = __('cmn.reference') .' '. __('cmn.list');
        $data['title'] = __('cmn.reference') .' '. __('cmn.list');
        $data['unique_relation_names'] = SettingStaffReference::latest()->get(['relation'])->unique('relation');

        $data['lists'] = SettingStaffReference::where('staff_id', $staff_id)->orderBy('id', 'asc')->get();

        return view('staff.reference_list', $data);
    }

    public function store(Request $request)
    {

        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        try {

            $model = new SettingStaffReference();
            $model->staff_id = $request->input('staff_id');
            $model->referrer = $request->input('referrer');
            $model->relation = $request->input('relation');
            $model->phone = $request->input('phone');
            $model->nid_number = $request->input('nid_number');
            $model->address = $request->input('address');
            $model->save();

            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back();

        } catch (Exception $e) {

            Toastr::error('',$e->message());
            return redirect()->back();
        }
    }
  
    public function update(Request $request, $id){
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        try {

            $model = SettingStaffReference::find($id);
            $model->staff_id = $request->input('staff_id');
            $model->referrer = $request->input('referrer');
            $model->relation = $request->input('relation');
            $model->phone = $request->input('phone');
            $model->nid_number = $request->input('nid_number');
            $model->address = $request->input('address');
            $model->save();

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

        if (!SettingStaffReference::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }

        try {

            $model = SettingStaffReference::find($id);
            $model->update(['updated_by'=> Auth::user()->id]);
            $model->delete();

            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();

        } catch (\Exception $e) {

            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();

        }
    }

    public function makeMainReferrer($id){

        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        if (!SettingStaffReference::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }

        try {

            $model = SettingStaffReference::find($id);

            // make 0 for all referrer of this staff
            $staff = SettingStaffReference::where('staff_id', $model->staff_id)->update(['main_referrer'=> 0, 'updated_by'=> Auth::user()->id]);

            // make main
            $model->update(['main_referrer'=> 1, 'updated_by'=> Auth::user()->id]);

            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back();

        } catch (\Exception $e) {

            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();

        }
    }
 
    






}