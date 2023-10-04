<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Toastr;
use Setting;


class SettingController extends Controller
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
        $data['title'] = __('cmn.setting');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'setting';
        return view('settings.setting', $data);
    }

    public function system()
    {
        $data['title'] = __('cmn.system_setting');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'system';
        $data['setting'] = Setting::get('client_system');
        return view('settings.system', $data);
    }

    // SettingRequest
    public function saveSystem(Request $request)
    {
 
        Setting::set('client_system.default_challan', $request->input('default_challan'));
        Setting::set('client_system.company_name', $request->input('company_name'));
        Setting::set('client_system.slogan', $request->input('slogan'));
        Setting::set('client_system.address', $request->input('address'));
        Setting::set('client_system.phone', $request->input('phone'));
        Setting::set('client_system.email', $request->input('email'));
        Setting::set('client_system.website', $request->input('website'));
        Setting::set('client_system.oil_rate', $request->input('oil_rate'));
        
        // image
        Setting::set('client_system.favicon', $request->input('favicon'));
        Setting::set('client_system.logo', $request->input('logo'));

        // notifcation
        Setting::set('client_system.notify_days_for_document', $request->input('notify_days_for_document'));
        Setting::set('client_system.notify_days_for_mobil', $request->input('notify_days_for_mobil'));
        Setting::set('client_system.notify_days_for_tyre', $request->input('notify_days_for_tyre'));
        
        Setting::save();
        Toastr::success('Successfully Saved', 'Success');
        return redirect()->back();
    }

    public function admin()
    {
        $data['title'] = __('cmn.admin') . ' '. __('cmn.setting');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'system';
        $data['setting'] = Setting::get('admin_system');
        return view('settings.admin', $data);
    }

    // SettingRequest
    public function saveAdmin(Request $request)
    {
        Setting::set('admin_system.business_type', $request->input('business_type'));
        Setting::set('admin_system.max_own_vehicle_qty', $request->input('max_own_vehicle_qty'));
        Setting::set('admin_system.max_challan_qty_per_month', $request->input('max_challan_qty_per_month'));
        Setting::set('admin_system.last_date_of_bill_payment', $request->input('last_date_of_bill_payment'));
        Setting::set('admin_system.total_bill', $request->input('total_bill'));
        Setting::set('admin_system.notify_days_for_bill', $request->input('notify_days_for_bill'));
        Setting::set('admin_system.due_payment_action', $request->input('due_payment_action'));
        
        Setting::save();
        Toastr::success('Successfully Saved', 'Success');
        return redirect()->back();
    }
}
