<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\SettingSupplier;
use App\Services\CommonService;

use Auth;
use Toastr;

class SupplierController extends Controller
{

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
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.suppliers').' '.__('cmn.setting').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.suppliers').' '.__('cmn.setting').' '.__('cmn.page');
        $data['request'] = $request;
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'suppliers';
        $query = SettingSupplier::query();
        if($request->name_phone){
            $query = $query->where('name', 'like', '%' . $request->name_phone . '%')
                        ->orWhere('phone', 'like', '%' . $request->name_phone . '%');
        }
        $data['suppliers'] = $query->orderBy('sort', 'asc')->paginate(50);
        return view('settings.suppliers', $data);
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
            'name' => 'required',
        ]);
        try {
            $settingSupplierModel = new SettingSupplier();
            $finalData = collect($request->only($settingSupplierModel->getFillable()))
                                ->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id])
                                ->toArray(); 
            $tableData = $settingSupplierModel->create($finalData);
            // CommonService::activity($tableData->getTable(),$tableData->id);
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
            'name' => 'required',
        ]);
        try {
            $settingSupplierModel = new SettingSupplier();
            $finalData = collect($request->only($settingSupplierModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            $tableData = SettingSupplier::find($id)->update($finalData);
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
            $supplier = SettingSupplier::find($id);
            $supplier->update(['updated_by'=> Auth::user()->id]);
            $supplier->delete();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }
}
