<?php

namespace App\Http\Controllers\Vehicle;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingStaff;
use App\Models\Settings\SettingBrand;


use App\Http\Requests\Setting\VehicleRequest;

use Auth;
use Toastr;
use Carbon\Carbon;
use DB;

class VehicleController extends Controller
{

    public function index(Request $request)
    {

        $data['request'] = $request;
        $data['menu'] = 'vehicle';
        $data['sub_menu'] = 'list';
        
        $data['top_title'] = __('cmn.vehicle') .' '. __('cmn.list');
        $data['title'] = __('cmn.vehicle') .' '. __('cmn.list');

        $query = SettingVehicle::query();

        if($request->input('number_plate')){
            $query = $query->where('number_plate', 'like', '%' . $request->input('number_plate') . '%');
        }

        $data['lists'] = $query->orderBy('vehicle_serial', 'asc')->paginate(50);

        return view('vehicle.list', $data);
    }

    public function create(Request $request)
    {
        $data['request'] = $request;
        $data['menu'] = 'vehicle';
        $data['sub_menu'] = 'list';
        
        $data['top_title'] = __('cmn.vehicle') .' '. __('cmn.add') .' '. __('cmn.form');
        $data['title'] =  __('cmn.vehicle') .' '. __('cmn.add') .' '. __('cmn.form');
        $data['drivers'] = SettingStaff::where('designation_id', 1)->get();
        $data['helpers'] = SettingStaff::where('designation_id', 2)->get();
        $data['brands'] = SettingBrand::orderBy('sort','asc')->get();

        return view('vehicle.create', $data);
    }

    //                                                                                                                         
    public function store(VehicleRequest $request)
    {
        // dd($request);
        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        DB::beginTransaction();
        try {

            $model = new SettingVehicle();
            $finalData = collect($request->only($model->getFillable()))
                            ->merge(['encrypt' => uniqid(), 'created_by'=> Auth::user()->id])
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

    public function edit($id){
        if (!SettingVehicle::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }
        
        $data['menu'] = 'vehicle';
        $data['sub_menu'] = 'list';
        
        $data['top_title'] = __('cmn.vehicle') .' '. __('cmn.edit') .' '. __('cmn.form');
        $data['title'] =  __('cmn.vehicle') .' '. __('cmn.edit') .' '. __('cmn.form');

        $data['drivers'] = SettingStaff::where('designation_id', 1)->get();
        $data['helpers'] = SettingStaff::where('designation_id', 2)->get();
        $data['brands'] = SettingBrand::orderBy('sort','asc')->get();
        $data['data'] = SettingVehicle::where('id', $id)->first();

        return view('vehicle.edit', $data);
    }
    
    // StaffRequest
    public function update(Request $request, $id){
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }

        try {
            $settingStaffModel = new SettingVehicle();
            $finalData = collect($request->only($settingStaffModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            $tableData = SettingVehicle::find($id)->update($finalData);

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
        if (!SettingVehicle::where('id', $id)->exists()) {
            Toastr::error('',__('cmn.did_not_find'));
            return redirect()->back();
        }
        try {
            $staff = SettingVehicle::find($id);
            $staff->update(['updated_by'=> Auth::user()->id]);
            $staff->delete();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }

    public function documents(Request $request)
    {

        $data['request'] = $request;
        $data['menu'] = 'vehicle_documents';
        $data['sub_menu'] = '';
        
        $data['top_title'] = __('cmn.document_notification') .' '. __('cmn.list');
        $data['title'] = __('cmn.document_notification') .' '. __('cmn.list');

        $query = SettingVehicle::query();

        if($request->input('number_plate')){
            $query = $query->where('number_plate', 'like', '%' . $request->input('number_plate') . '%');
        }

        $data['lists'] = $query->orderBy('vehicle_serial', 'asc')->paginate(50);

        return view('vehicle.document_list', $data);
    }
 
    // public function sort_update(Request $request){
    //     $this->validate($request,[
    //         'sort' => 'required', 
    //         'id' => 'required',
    //     ]);
    //     if(SettingVehicle::find($request->input('id'))->update(['sort'=> $request->input('sort'), 'updated_by'=> Auth::user()->id])){
    //         Toastr::success('',__('cmn.successfully_updated'));
    //         return redirect()->back();
    //     } else {
    //         Toastr::error('',__('cmn.did_not_updated'));
    //         return redirect()->back();
    //     }
    // }

    // public function status(Request $request){

    //     // dd( $request);

    //     $this->validate($request,[
    //         'id' => 'required',
    //         'status' => 'required', 
    //     ]);
    //     if(SettingVehicle::find($request->input('id'))->update(['status'=> $request->input('status'), 'updated_by'=> Auth::user()->id])){
    //         Toastr::success('',__('cmn.successfully_updated'));
    //         return redirect()->back();
    //     } else {
    //         Toastr::error('',__('cmn.did_not_updated'));
    //         return redirect()->back();
    //     }
    // }

    // function details($id){
    //     if (!SettingVehicle::where('id', $id)->exists()) {
    //         Toastr::error('',__('cmn.did_not_find'));
    //         return redirect()->back();
    //     }

    //     $data['menu'] = 'staff';
    //     $data['sub_menu'] = 'list';
        
    //     $data['top_title'] = __('cmn.details');
    //     $data['title'] = __('cmn.details');
    //     $data['data'] = SettingStaff::where('id', $id)->first();

    //     return view('staff.details', $data);
    // }

    

}
