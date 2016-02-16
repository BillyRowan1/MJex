<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
use Mjex\User;

class FindGrowerController extends Controller
{
    public function getIndex()
    {
        return view('find_growers');
    }

    public function postIndex(Request $request)
    {
        $this->validate($request,[
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ]);

        $mjexUsers = User::all();
        $bcc = [];
        foreach($mjexUsers as $mjexUser){
            if($mjexUser->type=="seller" && in_array('grower',json_decode($mjexUser->purpose))){
                $bcc[] = $mjexUser->email;
            }
        }

        $user['subject'] = $request->input('subject','Patient to Grower');
        $user['message'] = $request->input('message','');
        $user['name'] = $request->input('name','');
        $user['email'] = $request->input('email','');

        Mail::send('emails.find_growers', ['user' => $user], function ($m) use ($user, $bcc) {
            $m->to($bcc)->subject('Patient to Grower: ' . $user['subject']);
        });

        return redirect()->back()->with('message','Message sent');
    }
}
