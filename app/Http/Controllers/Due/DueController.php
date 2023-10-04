<?php

namespace App\Http\Controllers\Due;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Client;

use DB;
use Auth;
use Toastr;
use Carbon\Carbon;

class DueController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['title'] = 'Due';
        $data['menu'] = 'due';
        $data['sub_menu'] = 'dues';
        $data['clients'] = Client::orderBy('client_sort', 'asc')->get();
        return view('due.due', $data);
    }
}
