<?php
namespace App\Http\Controllers\Settings;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\SettingArea;
use App\Models\Settings\SettingDivision;
use App\Services\CommonService;
use Auth;
use Toastr;

class AreaController extends Controller
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
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.Load/Unload_Point_List').' '.__('cmn.setting').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.Load/Unload_Point_List').' '.__('cmn.setting').' '.__('cmn.page');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'area';
        $data['divisions'] = SettingDivision::where('status', 1)->get();

        $query = SettingArea::query()->with('division');
        if($request->input('name')){
            $query = $query->where('name', 'like', '%' . $request->input('name') . '%');
        }
        if($request->input('division_id')){
            $query = $query->where('division_id', $request->input('division_id'));
        }
        $data['lists'] = $query->orderBy('id', 'desc')->paginate(50);
        return view('settings.area', $data);
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
            'name' => "required | unique:setting_areas,name",
            'division_id' => "required",
        ]);
        try {
            $settingAreaModel = new SettingArea();
            $finalData = collect($request->only($settingAreaModel->getFillable()))
                            ->merge(['encrypt'=> uniqid(), 'created_by'=> Auth::user()->id])
                            ->toArray(); 
            $tableData = $settingAreaModel->create($finalData);
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
            'name' => "required | unique:setting_areas,name, $id",
            'division_id' => "required",
        ]);
        try{
            $SettingAreaModel = new SettingArea();
            $finalData = collect($request->only($SettingAreaModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
             $settingArea = SettingArea::find($id);
             $settingArea->update($finalData);
            //  CommonService::activity($tableData->getTable(),$tableData->id,'updated_this_item');
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
            $area = SettingArea::find($id);
            $area->update(['updated_by'=> Auth::user()->id]);
            $area->delete();
            // CommonService::activity($tableData->getTable(),$tableData->id,'deleted_this_item');
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }
}
