<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Jobs\MatchSendSms;
use Auth;

class SmsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $datas = [
            ['number' => '01714078743', 'message' => 'sms 1'],
            ['number' => '01779325718', 'message' => 'sms 2'],
            ['number' => '01988139009', 'message' => 'sms 3'],

            // ['number' => '01714078743', 'message' => 'sms 4'],
            // ['number' => '01714078743', 'message' => 'sms 5'],
            // ['number' => '01714078743', 'message' => 'sms 6'],
            // ['number' => '01714078743', 'message' => 'sms 7'],
            // ['number' => '01714078743', 'message' => 'sms 8'],
            // ['number' => '01714078743', 'message' => 'sms 9'],
            // ['number' => '01714078743', 'message' => 'sms 10'],
            // ['number' => '01714078743', 'message' => 'sms 11'],
            // ['number' => '01714078743', 'message' => 'sms 12'],
        ];
        foreach($datas as $data){
            // dd($data['number']);
            // dd($data['message']);

            $smsJob = new MatchSendSms($data['number'],$data['message']);
            dispatch($smsJob);
        }

        // chunk from database
        // jobs queue


        // $SmsService = new SmsService();
        // return $SmsService->smsFire('01714078743', 'test message');



    }



    
}