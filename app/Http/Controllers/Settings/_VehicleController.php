<?php

namespace App\Http\Controllers\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingSupplier;
use App\Models\Settings\SettingStaff;
use App\Models\Settings\SettingDivision;
use App\Services\CommonService;

use DB;
use Auth;
use Toastr;

class VehicleController extends Controller{
    /**
     * construct of this class
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {        
        $data['request'] = $request;
        $data['cars'] = SettingVehicle::with('driver','helper')->orderBy('sort','desc')->paginate(50);
        $data['drivers'] = SettingStaff::where('designation_id', 1)->get();
        $data['helpers'] = SettingStaff::where('designation_id', 2)->get();
        $data['suppliers'] = SettingSupplier::get();
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.vehicle').' '.__('cmn.setting').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.vehicle').' '.__('cmn.setting').' '.__('cmn.page');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'vehicle_list';
        return view('settings.vehicle.vehicle_list', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
       $this->validate($request,[
            'vehicle_number' => 'required', // need to unique
        ]);
        try {
            $settingVehicleModel = new SettingVehicle();
            $finalData = collect($request->only($settingVehicleModel->getFillable()))
                                ->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id])
                                ->toArray(); 
            $tableData = $settingVehicleModel->create($finalData);
            // CommonService::activity($tableData->getTable(),$tableData->id);
            Toastr::success('',__('cmn.successfully_added'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_added'));
            return redirect()->back();
        }
    }

    public function edit($id)
    {
        if(!empty($id)){
            $data = SettingVehicle::find($id);
            if(!empty($data)){
                return response(['status'=>true, 'message' => 'Vehicle Found', 'data' => $data]);
            }
        }
        return response(['status'=>false, 'message' => 'Vehicle not Found', 'data' => []]);
    }
 
    public function update(Request $request, $id)
    {
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        $this->validate($request,[
            'vehicle_number' => 'required'  // need to unique
        ]);
        try{
            // data process
            if($request->input('ownership_type') == 1){
                $supplier_id = null;
            } else {
                $supplier_id = $request->input('supplier_id');
            }
            $settingVehicleModel = new SettingVehicle();
            $finalData = collect($request->only($settingVehicleModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            SettingVehicle::find($id)->update($finalData);
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
            $vehicle = SettingVehicle::find($id);
            $vehicle->update(['updated_by'=> Auth::user()->id]);
            $vehicle->delete();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function document_edit($encrypt)
    {
        if(Vehicle::where('car_encrypt',$encrypt)->exists()){
            $data['list'] = Vehicle::where('car_encrypt',$encrypt)->first();
            $data['drivers'] = People::where('people_desig_id',2)->get();
            $data['helpers'] = People::where('people_desig_id',3)->get();
            $data['car_types'] = CarType::all();
            $data['title'] = 'Vehicle Document Form';
            $data['menu'] = 'vehicle';
            $data['sub_menu'] = 'vehicle_list';
            return view('vehicle.vehicle_document', $data);
        }else{
            Toastr::error('Did not found!', 'Sorry');
            return redirect()->back();
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function document_update(Request $request, $encrypt)
    {
        // update & try catch
        try{
            $data = Vehicle::where('car_encrypt', $encrypt)->first();
            $data->car_reg_number = $request->car_reg_number;
            $data->car_reg_date = $request->car_reg_date;
            $data->car_reg_reminder_date = $request->car_reg_reminder_date;
            $data->car_engine = $request->car_engine;
            $data->car_chassis = $request->car_chassis;
            $data->car_model = $request->car_model;
            $data->car_cc = $request->car_cc;
            $data->car_horse = $request->car_horse;
            $data->save();
            Toastr::success('Successfully update!', 'Succcess');
            return redirect()->back();
        } catch(ModelNotFoundException $e) {
            Toastr::error('Did not updated!', 'Sorry');
            return redirect()->back();
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function history_print($encrypt)
    {
        if(Vehicle::where('car_encrypt',$encrypt)->exists()){
            $data['title'] = 'Vehicle History Report';
            $data['menu'] = 'setting';
            $data['sub_menu'] = 'vehicle_list';
            return view('vehicle.report.vehicle_history_report', $data);
        }else{
            Toastr::error('Did not found!', 'Sorry');
            return redirect()->back();
        }
    }
        /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Subject  $subject
     * @return \Illuminate\Http\Response
     */
    public function document_print($encrypt)
    {
        if(Vehicle::where('car_encrypt',$encrypt)->exists()){
            $data['title'] = 'Vehicle Document Print';
            $data['menu'] = 'setting';
            $data['sub_menu'] = 'vehicle_list';
            return view('vehicle.report.vehicle_document_report', $data);
        }else{
            Toastr::error('Did not found!', 'Sorry');
            return redirect()->back();
        }
    }


    public function supplier_wise_vehicle($supplier_id){
        if(!empty($supplier_id)){
            $data = SettingVehicle::where('supplier_id', $supplier_id)->get();
            if(!empty($data)){
                return response(['status'=>true, 'message' => 'Vehicle Found', 'data' => $data]);
            }
        }
        return response(['status'=>false, 'message' => 'Vehicle not Found', 'data' => []]);
    }
}