<?php

namespace App\Http\Controllers;

use App\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Shares\Share;

use DB;
use Auth;
use Toastr;

class PublicController extends Controller{


    public function index($encrypt)
    {      

        // first or failed
        // expiration
        // generate pdf
        // show pdf in a encrypt link

        
        $data['share'] = Share::where('encrypt', $encrypt)->first();

        dd($data['share']);

        // dd('from public controller +'. $encrypt);
        // dd('from public controller');


        // $data['request'] = $request;
        // $data['top_title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.user_activity').' '.__('cmn.page');
        // $data['title'] = __('cmn.now_you_are_on_the') .' '.__('cmn.user_activity').' '.__('cmn.page');
        // $data['menu'] = 'activites';
        // $data['sub_menu'] = '';
        // $data['lists'] = Activity::Paginate(50);

        // return view('activity.activity', $data);
    }
}