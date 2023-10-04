<?php

namespace App\Http\Controllers\Settings;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use PHPUnit\Framework\Exception;

use App\Models\Settings\SettingDefault;
use App\Http\Requests\PumpRequest;
use Auth;
use Toastr;


class DefaultController  extends Controller
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
    public function index()
    {
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.company_setup').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.company_setup').' '.__('cmn.page');
        $data['menu'] = 'setting';
        $data['sub_menu'] = 'company';
        $data['configs'] = SettingDefault::all();
        return view('settings.default', $data);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        $db_logo = SettingDefault::where('key','logo')->first();
		$db_favicon = SettingDefault::where('key','favicon')->first();
        // get logo
		$logo = $request->file('logo');
        if(isset($logo)){
            $site_logo = 'logo'.uniqid().'.'.$logo->getClientOriginalExtension();
            if($db_logo->value != 'default_logo.svg'){
                if (Storage::disk('public')->exists('setting/'.$db_logo->value)) {
                    Storage::disk('public')->delete('setting/'.$db_logo->value);
                }
            }
            Storage::disk('public')->putFileAs('setting', $logo, $site_logo);
        } else{
            $site_logo = $db_logo->value;
		}
		//get favicon
		$favicon = $request->file('favicon');
        if(isset($favicon)){
            $site_favicon = 'favicon'.uniqid().'.'.$favicon->getClientOriginalExtension();
			if (Storage::disk('public')->exists('setting/'.$db_favicon->value)) {
                Storage::disk('public')->delete('setting/'.$db_favicon->value);
			}
            Storage::disk('public')->putFileAs('setting', $favicon, $site_favicon);
		}
		 else{
            $site_favicon = $db_favicon->value;
        }
        // array
        $arr_data = array(
		  'company_name' => $request->company_name,
		  'slogan' =>  $request->slogan,
		  'address' =>  $request->address,
          'phone' => $request->phone,
          'email' => $request->email,
          'website' => $request->website,
          'logo' => $site_logo,
          'favicon' => $site_favicon,
          'oil_rate' => $request->oil_rate,
          'transport_booking_time' => $request->transport_booking_time,
          'transport_booking_distance' => $request->transport_booking_distance,
          'transport_expense' => $request->transport_expense,
          'trip_booking_time' => $request->trip_booking_time,
          'trip_booking_distance' => $request->trip_booking_distance,
          'meghna_bridge_distance_show' => $request->meghna_bridge_distance_show,
        );
        // updating or inserting
		foreach($arr_data as $key=>$val) {
			try {
				if(SettingDefault::where('key',$key)->exists()) {
					$result=SettingDefault::where('key', $key)->update(['value' => $val]);
				} else {
					$config['key'] = $key;
					$config['value'] = $val;
					$result=SettingDefault::insert($config);
				} 
			} catch (Exception $e) {
				Toastr::warning('আপডেট হতে পারিনি','দুঃখিত');
			}
			
		}
        Toastr::success('আপডেট হয়েছে' ,'সফল');
		return redirect()->back();
    }
}