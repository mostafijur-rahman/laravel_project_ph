<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SystemSetups\SystemSetup;
use Toastr;
use Auth;

class SystemSetupController extends Controller
{

    function index(){
        $data['title'] = 'Init config';
        $data['menu'] = '';
        $data['info'] = SystemSetup::get();
        return view('system_setup.init_config', $data);
    }

    

    public function saveInitConfig(Request $request)
    {

        $requests = $request->except('_token');
        if(count($requests) > 0){

            foreach($requests as $key => $value ){
            	if(SystemSetup::where('key', $key)->exists()) {
					SystemSetup::where('key', $key)->update(['value' => $value]);
				} else {
					SystemSetup::insert(['key'=>$key, 'value'=>$value]);
				}
            }

            // SystemSetup::where('key', 'updated_by')->update(['value' => Auth::user()->id]);
            
            Toastr::success('আপডেট হয়েছে' ,'সফল');
            return redirect()->back();

        } else {
            Toastr::warning('আপডেট হতে পারিনি','দুঃখিত');
            return redirect()->back();
        }





        	// try {
			// 	if(SystemSetup::where('key',$key)->exists()) {
			// 		$result=SettingDefault::where('key', $key)->update(['value' => $val]);
			// 	} else {
			// 		$config['key'] = $key;
			// 		$config['value'] = $val;
			// 		$result=SettingDefault::insert($config);
			// 	} 
			// } catch (Exception $e) {
			// 	Toastr::warning('আপডেট হতে পারিনি','দুঃখিত');
			// }


    }



}
