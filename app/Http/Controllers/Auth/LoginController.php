<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Get the login username to be used by the controller.
     *
     * @return string
     */
    // public function username()
    // {
    //     return 'username';
    // }
    /**
     * Show the application's login form.
     *
     * @return \Illuminate\Http\Response
     */
    public function showLoginForm()
    {
        $data['title'] = __('cmn.login');
        $names = [

            'aminul_islam_mamun_1.jpg',
            'aminul_islam_mamun_2.jpg',
            'aminul_islam_mamun_3.jpg',
            
            'bg_4.jpg',
            'sagor_isLam_joy.jpg',

            'md_kauchar_ahmed_tuhin.jpg',
            'raaj_01.jpg',
            'raaj_02.jpg',
            'bg_5.jpg',

        ];
        $name_key = array_rand($names);
        $data['bg_file_name'] =$names[$name_key];

        return view('auth.login', $data);
    }
    
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    // protected $redirectTo = RouteServiceProvider::HOME;
    protected $redirectTo = '/dashboard?time_range=all_time&dashboard=two';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
