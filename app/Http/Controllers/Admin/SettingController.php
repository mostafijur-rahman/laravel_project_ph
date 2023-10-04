<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Setting;
use Toastr;

class SettingController extends Controller
{

    public function system()
    {
        $data['title'] = __('cmn.system_setting');
        $data['menu'] = 'settings';
        $data['sub_menu'] = 'email';
        $data['setting'] = Setting::get('system');
        return view('admin.setting.system', $data);
    }

    // SettingRequest
    public function saveSystem(Request $request)
    {
 
        Setting::set('system.default_challan', $request->input('default_challan'));

        Setting::save();
        Toastr::success('Successfully Saved', 'Success');
        return redirect()->back();
    }

}
