<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use Toastr;

use App\Models\User\Role;

class RoleController extends Controller
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
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.user_role').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.user_role').' '.__('cmn.page');
        $data['menu'] = 'user';
        $data['sub_menu'] = 'role';
        $data['lists'] = Role::get();
        return view('user.role', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){        
        $this->validate($request,[
            'name' => 'required|unique:user_roles',
        ]);
        try {
            $userModel = new Role();
            $fillableData = collect($request->only($userModel->getFillable()));
            $finalData = $fillableData->merge(['created_by'=> Auth::user()->id]);   
            $userModel->create($finalData->toArray());
            Toastr::success(__('cmn.successfully_added'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error(__('cmn.did_not_added'), __('cmn.sorry'));
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
        $this->validate($request,[
            'name' => 'required|unique:user_roles,name,'.$id.',id'
        ]);
        $data = [
            'updated_by'=> Auth::user()->id,
            'create'=> ($request->has('create'))?1:0,
            'edit'=> ($request->has('edit'))?1:0,
            'delete'=> ($request->has('delete'))?1:0
        ];
        try {
            $userModel = new Role();
            $fillableData = collect($request->only($userModel->getFillable()));
            $userModel = Role::where('id', $id)->first();
            $finalData = $fillableData->merge($data);   
            $userModel->update($finalData->toArray());
            Toastr::success(__('cmn.successfully_updated'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error(__('cmn.did_not_added'), __('cmn.sorry'));
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
        try {
            $role = Role::find($id);
            $role->update(['updated_by'=> Auth::user()->id]);        
            $role->delete();
            Toastr::success(__('cmn.successfully_deleted'),__('cmn.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            Toastr::error(__('cmn.did_not_deleted'),__('cmn.sorry'));
            return redirect()->back();
        }
    }
}
