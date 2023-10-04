<?php
namespace App\Http\Controllers\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

use Auth;
use Toastr;

use App\User;
use App\Models\User\Role;

class UserController extends Controller
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
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.system_user').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.system_user').' '.__('cmn.page');
        $data['menu'] = 'user';
        $data['sub_menu'] = 'list';
        $data['positions'] = Role::get();
        $query = User::query();
        if($request->position_id){
            $query = $query->where('position_id', $request->position_id);
        }
        if($request->name_or_email){
            $query = $query->where('first_name', 'like', '%' . $request->name_or_email . '%')
                            ->where('last_name', 'like', '%' . $request->name_or_email . '%')
                            ->where('email', 'like', '%' . $request->name_or_email . '%');
        }
        $data['lists'] = $query->orderBy('created_at', 'desc')->paginate(50);
        return view('user.user', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
       $this->validate($request,[
            'role_id' => 'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|required_with:password_confirmation|same:password_confirmation',
        ]);
        try {
            $userModel = new User();
            $fillableData = collect($request->only($userModel->getFillable()));
            $finalData = $fillableData->merge(['password' => Hash::make($request->input('password')),'status'=> 'active', 'created_by'=> Auth::user()->id]);   
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
            'role_id' => 'required',
            'first_name' => 'required',
            'email' => 'required|email|unique:users,email,'.$id.',id'
        ]);
        try {
            $userModel = new User();
            $finalData = collect($request->only($userModel->getFillable()))
                            ->merge(['updated_by'=> Auth::user()->id])
                            ->toArray();
            User::find($id)->update($finalData);
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
            $user = User::find($id);
            $user->update(['updated_by'=> Auth::user()->id]);
            $user->delete();
            // DB::commit();
            Toastr::success(__('cmn.successfully_deleted'),__('cmn.success'));
            return redirect()->back();
        }catch (\Exception $e) {
            DB::rollBack();
            Toastr::error(__('cmn.did_not_deleted'),__('cmn.sorry'));
            return redirect()->back();
        }
    }

    public function changePassword(Request $request, $id){
        $this->validate($request,[
            'password' => 'required|required_with:password_confirmation|same:password_confirmation',
        ]);
        try {
            $userModel = new User();
            $fillableData = collect($request->only($userModel->getFillable()));
            $userModel = User::where('id', $id)->first();
            $finalData = $fillableData->merge(['password' => Hash::make($request->input('password')),'updated_by'=> Auth::user()->id]); 
            $userModel->update($finalData->toArray());
            Toastr::success(__('cmn.successfully_updated'));
            return redirect()->back(); 
        }catch (\Exception $e) {
            Toastr::error(__('cmn.did_not_added'), __('cmn.sorry'));
            return redirect()->back();
        }
    }
    
}
