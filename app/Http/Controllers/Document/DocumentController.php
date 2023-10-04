<?php
namespace App\Http\Controllers\Document;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Settings\SettingVehicle;

use Auth;
use Toastr;

use App\Models\Documents\Document;

class DocumentController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $data['request'] = $request;
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.document').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.document').' '.__('cmn.page');
        $data['menu'] = 'documents';
        $data['sub_menu'] = 'list';
        $data['lists'] = SettingVehicle::with('driver','helper','document')->orderBy('sort','desc')->paginate(50);
        if($request->input('page') == 'reports'){
            $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.mobil').' '.__('cmn.report').' '.__('cmn.page');
            $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.mobil').' '.__('cmn.report').' '.__('cmn.page');
            $data['sub_menu'] = 'report';
            $data['request'] = $request;
            return view('document.report_form', $data);
    } 
        return view('document.document', $data);
    }
    
    public function store(Request $request)
    {
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        try {
            $model = new Document();
            $finalData = collect($request->only($model->getFillable())) 
                                ->merge(['created_by'=> Auth::user()->id])
                                ->toArray();
            $model->create($finalData);
            Toastr::success(__('cmn.successfully_updated'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error(__('cmn.did_not_added'), __('cmn.sorry'));
            return redirect()->back();
        }
    }

    public function update(Request $request, $id)
    {
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        try {
            $model = new Document();
            $finalData = collect($request->only($model->getFillable())) 
                                ->merge(['updated_by'=> Auth::user()->id])
                                ->toArray();
            Document::find($id)->update($finalData);
            Toastr::success(__('cmn.successfully_updated'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error(__('cmn.did_not_added'), __('cmn.sorry'));
            return redirect()->back();
        }
    }

    public function destroy($id){
        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        try {
            Document::find($id)->delete();
            Toastr::success('',__('cmn.successfully_deleted'));
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('',__('cmn.did_not_deleted'));
            return redirect()->back();
        }
    }
    public function report(Request $request){

        Toastr::error('',__('cmn.this_feature_has_been_disabled'));
        return redirect()->back();
    }
}
