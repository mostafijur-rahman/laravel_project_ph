<?php

namespace App\Http\Controllers\Activity;

use App\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use DB;
use Auth;
use Toastr;

class activityController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request)
    {      
        $data['request'] = $request;
        $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.user_activity').' '.__('cmn.page');
        $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.user_activity').' '.__('cmn.page');
        $data['menu'] = 'activites';
        $data['sub_menu'] = '';
        $data['lists'] = Activity::Paginate(50);
        return view('activity.activity', $data);
    }
}