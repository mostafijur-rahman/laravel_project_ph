<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Investor;

use Toastr;
use Auth;
use DB;

class SettingInvestorController extends Controller
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
        $data['title'] = 'Investor List';
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'investor';
        $data['lists'] = Investor::all();
        return view('settings.investor', $data);
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
            'name' => "required",
        ]);
        $data = new Investor();
        $data->encrypt = uniqid();
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->note = $request->note;
        $data->created_by = Auth::user()->id;
        $data->updated_by = Auth::user()->id;
        if($data->save()){
            Toastr::success('যুক্ত হয়েছে!', 'সফল', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } else{
            Toastr::error('যুক্ত হতে পারিনি!', 'দুঃখিত', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        $this->validate($request,[
            'name' => "required",
        ]);
        $data = Investor::where('id', $id)->first();
        $data->name = $request->name;
        $data->phone = $request->phone;
        $data->address = $request->address;
        $data->note = $request->note;
        $data->updated_by = Auth::user()->id;
        if($data->save()){
            Toastr::success('আপডেট হয়েছে!', 'সফল', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } else{
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
        $data = Investor::where('id', $id)->first();
        if($data->delete()){
            Toastr::success('ডিলেট হয়েছে!', 'সফল', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } else{
            Toastr::error('ডিলেট হতে পারিনি!', 'দুঃখিত', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
}
