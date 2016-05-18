<?php

namespace Mjex\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Mjex\User;
use Mjex\Http\Controllers\Controller;

class SessionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    public function getLogin()
    {
        return view('admin.login');
    }

    public function postLogin(Request $request)
    {
        $this->validate($request,[
            'username' => 'required',
            'password' => 'required'
        ]);

        if($request->input('username') == 'mjexadmin' && $request->input('password') == 'mjexadmin@!@#') {
            $request->session()->push('mjexadmin', 'mjexadmin');

            return redirect()->to('mjexadmin');
        }

        return redirect()->back()->with('message','Wrong username/password');
    }

    public function getLogout(Request $request)
    {
        $request->session()->forget('mjexadmin');

        return redirect()->to('mjexadmin');
    }
}
