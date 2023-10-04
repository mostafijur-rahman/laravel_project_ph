<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\SettingPosition;
use App\Services\CommonService;
use Auth;
use Toastr;

class PositionController extends Controller
{
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
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.tyre_position').' '.__('cmn.setting').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.tyre_position').' '.__('cmn.setting').' '.__('cmn.page');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'tyer-position';
        $data['lists'] = SettingPosition::orderBy('sort','asc')->Paginate(50);
        return view('settings.position', $data);
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
            $SettingPositionModel = new SettingPosition();
            $finalData = collect($request->only($SettingPositionModel->getFillable()))
                            ->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id])
                            ->toArray(); 
            $tableData = $SettingPositionModel->create($finalData);
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
            $SettingPositionModel = new SettingPosition();
            $finalData = collect($request->only($SettingPositionModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            $tableData = SettingPosition::find($id)->update($finalData);
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
            SettingPosition::find($id)->delete();;
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
        if(SettingPosition::find($request->input('id'))->update(['sort'=> $request->input('sort')])){
            Toastr::success('',__('cmn.successfully_updated'));
            return redirect()->back();
        } else {
            Toastr::error('',__('cmn.did_not_updated'));
            return redirect()->back();
        }
    }
}
