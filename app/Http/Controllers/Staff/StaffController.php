<?php

namespace App\Http\Controllers\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Settings\SettingStaff;
use App\Models\Settings\SettingDesignation;
use App\Models\Settings\SettingBank;
use App\Models\Settings\SettingVehicle;


use App\Http\Requests\Setting\StaffRequest;

use Auth;
use Toastr;
use Carbon\Carbon;
use DB;

class StaffController extends Controller
{

    public function index(Request $request)
    {

        // dd($request);
        // vehicle_number
        // vehicle_id

        $data['request'] = $request;
        $data['menu'] = 'staff';
        $data['sub_menu'] = 'list';
        
        $data['top_title'] = __('cmn.staff') .' '. __('cmn.list');
        $data['title'] = __('cmn.staff') .' '. __('cmn.list');

        $data['designations'] = SettingDesignation::all();
        $data['vehicles'] = SettingVehicle::all();

        $query = SettingStaff::query();

        if($request->input('designation_id')){
            $query = $query->where('designation_id', $request->input('designation_id'));
        }

        if($request->input('name_phone')){
            $query = $query->where('name', 'like', '%' . $request->input('name_phone') . '%')
                            ->orWhere('phone', 'like', '%' . $request->input('name_phone') . '%');
        }

        if($request->input('company_id')){
            $query = $query->where('company_id', 'like', '%' . $request->input('company_id') . '%');
        }

        if($request->input('nid_number')){
            $query = $query->where('nid_number', 'like', '%' . $request->input('nid_number') . '%');
        }

        if($request->input('driving_license_number')){
            $query = $query->where('driving_license_number', 'like', '%' . $request->input('driving_license_number') . '%');
        }

        if($request->input('vehicle_id')){

            $staff_ids = SettingVehicle::where('id', $request->input('vehicle_id'))->select('driver_id', 'helper_id')->first();

            if($staff_ids->driver_id){
                $query = $query->where('id', $staff_ids->driver_id);
            }

            if($staff_ids->helper_id){
                $query = $query->orWhere('id', $staff_ids->helper_id);
            }
        }
        
        $data['lists'] = $query->orderBy('sort', 'asc')->paginate(50);

        return view('staff.list', $data);
    }

    public function create(Request $request)
    {
        $data['request'] = $request;
        $data['menu'] = 'staff';
        $data['sub_menu'] = 'list';
        
        $data['top_title'] = __('cmn.staff') .' '. __('cmn.add') .' '. __('cmn.form');
        $data['title'] =  __('cmn.staff') .' '. __('cmn.add') .' '. __('cmn.form');

        $data['desigs'] = SettingDesignation::all();
        $data['banks'] = SettingBank::orderBy('sort','asc')->get();
        return view('staff.create', $data);
    }

    public function store(StaffRequest $request)
    {
        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        DB::beginTransaction();
        try {

            $model = new SettingStaff();
            $finalData = collect($request->only($model->getFillable()))
                            ->merge(['encrypt' => uniqid(), 'status' => 'active', 'created_by'=> Auth::user()->id])
                            ->toArray();
            $model->create($finalData);

            DB::commit();
            Toastr::success('',__('cmn.successfully_posted'));
            return redirect()->back();

        } catch (Exception $e) {
            DB::rollBack();
            Toastr::error('',$e->message());
            return redirect()->back();
        }
    }

    function edit($id){
        if (!SettingStaff::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }

        $data['menu'] = 'staff';
        $data['sub_menu'] = 'list';
        
        $data['top_title'] = __('cmn.staff') .' '. __('cmn.edit') .' '. __('cmn.form');
        $data['title'] =  __('cmn.staff') .' '. __('cmn.edit') .' '. __('cmn.form');

        $data['desigs'] = SettingDesignation::all();
        $data['banks'] = SettingBank::orderBy('sort','asc')->get();
        $data['data'] = SettingStaff::where('id', $id)->first();

        return view('staff.edit', $data);
    }
  
    public function update(StaffRequest $request, $id){
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        try {
            $settingStaffModel = new SettingStaff();
            $finalData = collect($request->only($settingStaffModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            $tableData = SettingStaff::find($id)->update($finalData);

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
        if (!SettingStaff::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
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

        $models = SettingStaff::all();

        foreach ($models as $model) {
            foreach ($request->order as $order) {
                if ($order['id'] == $model->id) {
                    $model->update(['sort' => $order['position']]);
                }
            }
        }
        
        return response(__('cmn.successfully_updated'), 200);
    }

    public function status(Request $request){

        // dd( $request);

        $this->validate($request,[
            'id' => 'required',
            'status' => 'required', 
        ]);
        if(SettingStaff::find($request->input('id'))->update(['status'=> $request->input('status'), 'updated_by'=> Auth::user()->id])){
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back();
        } else {
            Toastr::error('',__('cmn.did_not_updated'));
            return redirect()->back();
        }
    }

    public function details($id){
        if (!SettingStaff::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }

        $data['menu'] = 'staff';
        $data['sub_menu'] = 'list';
        
        $data['top_title'] = __('cmn.details');
        $data['title'] = __('cmn.details');
        $data['data'] = SettingStaff::where('id', $id)->first();

        return view('staff.details', $data);
    }

    // public function print($id){
    //     if (!SettingStaff::where('id', $id)->exists()) {
    //         Toastr::error('',__('cmn.did_not_find'));
    //         return redirect()->back();
    //     }

    //     $data['menu'] = 'staff';
    //     $data['sub_menu'] = 'list';
        
    //     $data['top_title'] = __('cmn.details');
    //     $data['title'] = __('cmn.details');
    //     $data['data'] = SettingStaff::where('id', $id)->first();

    //     return view('staff.report.single_profile', $data);
    // }




}