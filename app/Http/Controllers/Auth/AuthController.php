<?php

namespace Mjex\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Mjex\User;
use Validator;
use Mjex\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

class AuthController extends Controller
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

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest', ['except' => 'logout','getRegister']);
        $this->request = $request;
    }

    public function showRegistrationForm()
    {
        $package = $this->request->input('package');
        return view('auth.register',compact('package'));
    }

    /**
     * Sign up as Seller
     * @param Request $request
     * @return array|string
     */
    public function postRegister(Request $request)
    {
        $rules = [
            'email' => 'required|email',
            'password' => 'required',
            'community_name' => 'required|unique:users,community_name|min:3',
            'zipcode' => 'required|numeric',
        ];
        if($request->input('_type') == 'seller') {
            $rules['package'] = 'required';
            $rules['delivery'] = 'required|boolean';
        }
        $this->validate($request,$rules);

        $user = new User;
        $user->email = $request->input('email');
        $user->type = $request->input('_type');
        $user->password = \Hash::make($request->input('password'));
        $anonymous_email = $this->incrementalHash() . '@mjex.com';
        $user->anonymous_email = $anonymous_email;
        $user->community_name = $request->input('community_name');
        $user->zipcode = $request->input('zipcode');
        $user->package = $request->input('package','none');
        $user->delivery = $request->input('delivery',false);
        if($request->has('purpose')) $user->purpose = json_encode($request->input('purpose'));

        $user->save();
        return redirect()->back()->with('message','Thank you for sign up. Now you can login to our system using anonymous email: '. $anonymous_email);
    }

    private function incrementalHash($len = 6){
        $charset = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
        $base = strlen($charset);
        $result = '';

        $now = explode(' ', microtime())[1];
        while ($now >= $base){
            $i = $now % $base;
            $result = $charset[$i] . $result;
            $now /= $base;
        }
        return substr($result, -5);
    }
}
