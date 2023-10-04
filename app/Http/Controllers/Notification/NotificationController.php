<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Notifications\Notification;
use DB;

class NotificationController extends Controller
{

    public function index(Request $request){

        $data['request'] = $request;
        $data['top_title'] = __('cmn.all_notifications');
        $data['title'] = __('cmn.all_notifications');
        $data['menu'] = 'notification';
        $data['sub_menu'] = '';

        // seen
        // (new Notification)->update(['seen' => 1]);
        DB::table('notifications')->update(['seen' => 1]);

        $data['lists'] = Notification::orderBy('id', 'desc')->paginate(100);
        return view('notification.list', $data);

    }




}