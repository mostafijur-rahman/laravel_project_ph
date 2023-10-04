<?php

namespace App\Http\Controllers\Mobil;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Toastr;
use DB;

use App\Models\Mobils\Mobil;
use App\Models\Settings\SettingVehicle;
use App\Models\Settings\SettingBrand;

use App\Services\CommonService;


class MobilController extends Controller
{

    public function index(Request $request)
    {        
        $data['request'] = $request;
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.mobil').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.mobil').' '.__('cmn.page');
        $data['menu'] = 'mobils';
        $data['sub_menu'] = 'list';
        $data['vehicles'] = SettingVehicle::all();
        $data['brands'] = SettingBrand::all();
        $data['mobils']  = Mobil::with('vehicle','created_user','updated_user')
                                ->whereNotNull('attach_date')
                                ->orderBy('attach_date', 'desc')->Paginate(60);
        if($request->input('page') == 'reports'){
                $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.mobil').' '.__('cmn.report').' '.__('cmn.page');
                $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.mobil').' '.__('cmn.report').' '.__('cmn.page');
                $data['sub_menu'] = 'report';
                $data['request'] = $request;
                return view('mobil.report_form', $data);
        }                        
        return view('mobil.mobils', $data);
    }

    public function store(Request $request)
    {
        if(Auth::user()->role->create == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        try {
            $mobilModel = new Mobil();
            $fillableData = collect($request->only($mobilModel->getFillable()));
            $finalData = $fillableData->merge(['encrypt'=> uniqid(),'created_by'=> Auth::user()->id]);
            $mobilModel->create($finalData->toArray());
            Toastr::success(__('cmn.successfully_added'), __('cmn.success'));
            return redirect()->back();
        } catch (Exception $e) {
            Toastr::error(__('cmn.did_not_find'),__('cmn.sorry'));
            return redirect()->back();
        }
        
    }

    public function destroy($id){
        if(Auth::user()->role->delete == 0){
            Toastr::error('','Sorry you have no delete permission');
            return redirect()->back();
        }
        if (!Mobil::where('id', $id)->exists()) {
            Toastr::error(__('cmn.did_not_find'),__('cmn.sorry'));
            return redirect()->back();
        }
        try {
            DB::beginTransaction();
            $purchase = Mobil::find($id);
            $purchase->update(['updated_by'=> Auth::user()->id]);
            $purchase->delete();
            DB::commit();
            Toastr::success(__('cmn.successfully_deleted'),__('cmn.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('cmn.did_not_deleted'),__('cmn.sorry'));
            return redirect()->back();
        }
    }
    public function report(Request $request){

        Toastr::error('',__('cmn.this_feature_has_been_disabled'));
        return redirect()->back();
    }
}
