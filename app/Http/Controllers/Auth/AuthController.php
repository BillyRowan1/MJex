<?php

namespace Mjex\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Auth;
use Mjex\Events\UserRegistered;
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
        $package = $this->request->input('package','free');
        return view('auth.register',compact('package'));
    }

    public function login()
    {
        $email = $this->request->input('email');
        $password = $this->request->input('password');

        if (Auth::attempt(['email' => $email, 'password' => $password, 'active'=>1])) {
            return redirect()->intended($this->redirectTo);
        }

        return redirect()->back()
            ->withInput($this->request->only($this->loginUsername(), 'remember'))
            ->withErrors([
                $this->loginUsername() =>  "These credentials do not match our records. Or you haven't activated your account",
            ]);
    }

    /**
     * Sign up
     * @param Request $request
     * @return array|string
     */
    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'community_name' => 'required|unique:users,community_name|min:3|regex:/^[\pL\s\-]+$/u',
            'zipcode' => 'required',
        ];
        $customErrorMessages = [
            'community_name.unique' => 'The username has already been taken.',
            'community_name.required' => 'The username is required.',
            'community_name.regex' => 'The username format is invalid.',
        ];

        if($request->input('_type') == 'seller') {
            if($request->input('package') != 'free') $rules['stripeToken'] = 'required';
            $rules['package'] = 'required';
            $rules['delivery'] = 'required|boolean';
        }
        $this->validate($request,$rules,$customErrorMessages);
        $creditCardToken = $request->input('stripeToken');

        $user = new User;
        $user->email = $request->input('email');
        $user->type = $request->input('_type');
        $user->password = \Hash::make($request->input('password'));
        
        $user->community_name = $request->input('community_name');
        $user->zipcode = $request->input('zipcode');
        $user->state = $request->input('state');
        $user->package = $request->input('package','none');
        $user->delivery = $request->input('delivery',false);
        $user->active = 0;
        $user->activation_code = \Hash::make($user->email);
        if($request->has('purpose')) {
            $user->purpose = json_encode($request->input('purpose'));

            if(has_purpose('grower', $user)) {
                $user->patients_available = $request->input('patients_available');
            }
            if(has_purpose('medical', $user) && $user->type == 'seeker') {
                $user->medical_card_number = $request->input('medical_card_number');
                $user->desired_alotment = $request->input('desired_alotment');
            }
        }else{
            $user->purpose = json_encode([]);
        }
        if($user->type == 'seller' && $user->package != 'free') {
            // Subscribe this user
            $user->subscription($user->package)->create($creditCardToken);
        }
        $user->save();
        if($user->type == 'seller') {
            $anonymous_email = 'store' . $user->id . '@mjex.com';
        }else{
            $anonymous_email = $this->incrementalHash() . '@mjex.com';
        }
        $user->anonymous_email = $anonymous_email;
        $user->save();

        \Event::fire(new UserRegistered($user));

        return redirect()->back()->with('message','Thank you for signing up. Please check your email to active your account');
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
