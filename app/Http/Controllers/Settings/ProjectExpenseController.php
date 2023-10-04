<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProjectExpense;
use Auth;
use Toastr;

class ProjectExpenseController extends Controller
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
        $data['$request'] = $request;
        $data['title'] = 'Project Expense';
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'project_expense';
        // make query
        $query = ProjectExpense::query();
        if($request->type) {
            $query = $query->where('project_exp_type', $request->type);
        }
        if($request->name){
            $query = $query->where('project_exp_head', 'like', '%' . $request->name . '%');
        }
        $data['lists'] = $query->orderBy('project_exp_sort', 'asc')->paginate(50);
        $data['request'] = $request;
        return view('settings.project_expense', $data);
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
        if(ProjectExpense::where('project_exp_encrypt', $request->encrypt)
            ->update(['project_exp_sort'=> $request->sort])){
            Toastr::success('আপডেট হয়েছে!', 'সফল');
            return redirect()->back();
        } else {
            Toastr::error('আপডেট হতে পারিনি!', 'দুঃখিত');
            return redirect()->back();
        }
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
        // $this->validate($request,[
        //     'logo' => "required",
        //     'brand_name_en' => "required | unique:brands,brand_name_en",
        //     'brand_name_bn' => "required | unique:brands,brand_name_bn",
        //     'category_id' => "required",
        // ]);
        $data = new ProjectExpense();
        $data->project_exp_encrypt = uniqid();
        $data->project_exp_head = $request->name;
        $data->project_exp_description = null;
        $data->project_exp_sort = 1;
        $data->project_exp_type = $request->type;
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
    public function update(Request $request, $encrypt)
    {
        if(Auth::user()->role->edit == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        // $this->validate($request,[
        //     'brand_name_en' => "required | unique:brands,brand_name_en, $id",
        //     'brand_name_bn' => "required | unique:brands,brand_name_bn, $id",
        //     'category_id' => "required",
        // ]);

        $data = ProjectExpense::where('project_exp_encrypt', $encrypt)->first();

        // $logo = $request->file('logo');
        // $slug = str_slug($request->brand_name_en);
        // if(isset($logo)){
        //     $logo_name = $slug.uniqid().'.'.$logo->getClientOriginalExtension();
        //     if (Storage::disk('public')->exists('brand/'.$brand->logo)) {
        //         Storage::disk('public')->delete('brand/'.$brand->logo);
		// 	}
        //     Storage::disk('public')->putFileAs('brand', $logo, $logo_name);
        // } else{
        //     $logo_name = $brand->logo;
        // }
        $data->project_exp_head = $request->name;
        $data->project_exp_description = null;
        $data->project_exp_sort = 1;
        $data->project_exp_type = $request->type;
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
    public function destroy($encrypt)
    {
        if(Auth::user()->role->delete == 0){
            Toastr::error('',__('cmn.no_permission'));
            return redirect()->back();
        }
        $data = ProjectExpense::where('project_exp_encrypt', $encrypt)->first();
        // if (Storage::disk('public')->exists('brand/'.$brand->logo)) {
        //     Storage::disk('public')->delete('brand/'.$brand->logo);
        // }
        if($data->delete()){
            Toastr::success('ডিলেট হয়েছে!', 'সফল', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        } else{
            Toastr::error('ডিলেট হতে পারিনি!', 'দুঃখিত', ["positionClass" => "toast-bottom-right"]);
            return redirect()->back();
        }
    }
}
