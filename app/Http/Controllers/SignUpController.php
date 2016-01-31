<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
use Mjex\Seeker;
use Mjex\Seller;

class SignUpController extends Controller
{
    /**
     * Show sign up forms
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex(Request $request)
    {
        $package = $request->input('package');
        return view('signup', compact('package'));
    }

    /**
     * Sign up as Seeker
     * @param Request $request
     * @return array|string
     */
    public function postSeeker(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required',
            'community_name' => 'required|min:3',
            'zipcode' => 'required|numeric'
        ]);

        $user = new Seeker;
        $user->email = $request->input('email');
        $user->password = \Hash::make($request->input('password'));
        $anonymous_email = $this->incrementalHash() . '@mjex.com';
        $user->anonymous_email = $anonymous_email;
        $user->community_name = $request->input('community_name');
        $user->zipcode = $request->input('zipcode');
        if($request->has('purpose')) $user->purpose = json_encode($request->input('purpose'));

        $user->save();
        return redirect()->back()->with('message','Thank you for sign up as Seeker. Now you can login to our system using anonymous email: '. $anonymous_email);
    }

    /**
     * Sign up as Seller
     * @param Request $request
     * @return array|string
     */
    public function postSeller(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required',
            'community_name' => 'required|min:3',
            'zipcode' => 'required|numeric',
            'package' => 'required',
            'delivery' => 'required|boolean',
        ]);

        $user = new Seller;
        $user->email = $request->input('email');
        $user->password = \Hash::make($request->input('password'));
        $anonymous_email = $this->incrementalHash() . '@mjex.com';
        $user->anonymous_email = $anonymous_email;
        $user->community_name = $request->input('community_name');
        $user->zipcode = $request->input('zipcode');
        $user->package = $request->input('package');
        if($request->has('purpose')) $user->purpose = json_encode($request->input('purpose'));

        $user->save();
        return redirect()->back()->with('message','Thank you for sign up as Seller. Now you can login to our system using anonymous email: '. $anonymous_email);
        return $request->input();
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
