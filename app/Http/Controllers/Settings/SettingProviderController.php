<?php

namespace App\Http\Controllers\Settings;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\SettingProvider;
use DB;
use Auth;
use Toastr;


class SettingProviderController extends Controller
{

    public function __construct(){
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @author SH
     */
    public function index(Request $request)
    {
        $data['title'] = 'Vehicle Providers';
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'vehicle_providers';
        $data['request'] = $request;
        $query = SettingProvider::query();
        if($request->name_phone){
            $query = $query->where('name', 'like', '%' . $request->name_phone . '%')
                        ->orWhere('phone', 'like', '%' . $request->name_phone . '%');
        }
        $data['lists'] = $query->orderBy('sort', 'asc')->paginate(50);
        return view('settings.vehicle_providers', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        try {
            $data = new SettingProvider();
            $data->encrypt = uniqid();
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->note = $request->note;
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;
            $data->save();
            Toastr::success('যুক্ত হয়েছে!', 'সফল', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } catch (\Exception $e) {
            echo $e->getMessage();
            Toastr::error('যুক্ত হতে পারিনি!', 'দুঃখিত', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(!empty($id)){
            $data = SettingProvider::find($id);
            if(!empty($data)){
                return response(['status'=>true, 'message' => 'Vehicle Provider Found', 'data' => $data]);
            }
        }
        return response(['status'=>false, 'message' => 'Vehicle Provider not Found', 'data' => []]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        try {
            $data = SettingProvider::where('encrypt', $request->encrypt)->first();
            $data->name = $request->name;
            $data->phone = $request->phone;
            $data->address = $request->address;
            $data->note = $request->note;
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;
            $data->save();
            Toastr::success('আপডেট হয়েছে!', 'সফল', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } catch (\Exception $e) {
            echo $e->getMessage();
            Toastr::error('আপডেট হতে পারিনি!', 'দুঃখিত', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        try {
            $data = SettingProvider::findOrFail($id);
            $data->delete();
            Toastr::success('ডিলেট  হয়েছে!', 'সফল', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } catch (\Exception $e) {
            echo $e->getMessage();
            Toastr::error('ডিলেট করতে পারিনি!', 'দুঃখিত', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
}
