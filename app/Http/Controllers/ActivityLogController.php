<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\ActivityLog;
use App\User;
use App\Account;
use Auth;
use Toastr;

class ActivityLogController extends Controller
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
     * show the people list
     * @author MR
     */
    function index(Request $request){
        $data['menu'] = 'activity';
        if($request->id){
            $data['user'] = User::where('id', $request->id)->first();
            $data['activities'] = ActivityLog::where('user_id', $request->id)->get();
            $data['title'] = 'View Activity';
            return view('activity_log.view_activity', $data);
        }

        $data['title'] = 'Activity Log';
        $data['account_data'] = Account::orderBy('id','desc')->paginate(1000);
        // $data['lists'] = User::all();
        return view('activity_log.user_list', $data);
    }

}
