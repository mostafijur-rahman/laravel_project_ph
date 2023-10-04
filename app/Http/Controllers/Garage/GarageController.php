<?php

namespace App\Http\Controllers\Garage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Garage;

use DB;
use Auth;
use Toastr;

class GarageController extends Controller{
    /**
     * construct of this class
     *
     * @return void
     */
    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * show the people list
     * @author MR
     */
    function index(Request $request){
        $data['request'] = $request;
        $query = Garage::query();
        // if($request->name){
        //     $query=$query->where('pump_name', 'like', '%' . $request->name . '%');
        // }
        $data['lists'] = $query->orderBy('garage_expense_date','desc')->get();
        $data['title'] = 'Garage List';
        $data['menu'] = 'garage';
        $data['sub_menu'] = 'garage_list';
        return view('garage.garage_list', $data);
    }
    /**
     * update a  resource in storage.
     * @author MR
     */
    public function sort_update(Request $request){
        //  validation
        $this->validate($request,[
            'sort' => 'required', 
            'encrypt' => 'required',
        ]);
        if(Pump::where('pump_encrypt', $request->encrypt)
            ->update(['pump_sort'=> $request->sort])){
            Toastr::success('Successfully updated!', 'সফল');
            return redirect()->back();
        } else {
            Toastr::error('Did not updated', 'Sorry');
            return redirect()->back();
        }
    }
    /**
     * show the people add form
     * @author MR
     */
    function create(){
        $data['title'] = 'Pump Add Form';
        $data['menu'] = 'pump';
        $data['sub_menu'] = 'pump_create';
        return view('pump.pump_add', $data);
    }
    /**
     *  people data add
     * @author MR
     */
    function store(Request $request){
        $this->validate($request,[
            'name' => 'required',
        ]);
        try {
            $data = new Pump();
            $data->pump_encrypt = uniqid();
            $data->pump_name = $request->name;
            $data->created_by = Auth::user()->id;
            $data->updated_by = Auth::user()->id;
            $data->save();
            Toastr::success('Successfully Saved!', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            echo $e->getMessage();
            Toastr::error('Did not saved!', 'Sorry');
            return redirect()->back();
        }
    }
    /**
     * show the people edit form
     * @author MR
     */
    function edit($enc_id=null){
        if(Pump::where('pump_encrypt',$enc_id)->exists()){
            $data['title'] = 'Pump Edit Form';
            $data['pump'] = Pump::where('pump_encrypt',$enc_id)->first();
            $data['menu'] = 'pump';
            $data['sub_menu'] = 'pump_list';
            return view('pump.pump_edit', $data);
        }else{
            Toastr::error('Not found!', 'Sorry');
            return redirect()->back();
        }
    }
    /**
     * update a  resource in storage.
     * @author MR
     */
    public function update(Request $request, $enc_id){
        //  validation
        $this->validate($request,[
            'name' => 'required',
        ]);
        //some field under comment when this field is show 
        $data = Pump::where('pump_encrypt', $enc_id)->first();
        $data->pump_name = $request->name;
        $data->updated_by = Auth::user()->id;
        // save and redirect back
    	if($data->save()){
            Toastr::success('Successfull Updated!', 'Success');
            return redirect()->back();
        } else {
            Toastr::error('Did not Updated!', 'Sorry');
            return redirect()->back();
        }
    }
    /**
     * delete the specified resource from storage.
     * @author MR
     */
    public function destroy($encrypt){
        try {
            $data = Pump::where('pump_encrypt', $encrypt)->first();
            $data->delete();
            Toastr::success('Successfull Deleted!', 'Success');
            return redirect()->back();
        } catch (\Exception $e) {
            Toastr::error('Did not Deleted!', 'Sorry');
            return redirect()->back();
        }
    }
}