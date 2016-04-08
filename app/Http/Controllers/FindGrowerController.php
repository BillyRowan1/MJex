<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Mjex\Chat;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
use Mjex\User;

class FindGrowerController extends Controller
{
    public function getIndex()
    {
        $growers = User::where('type', 'seller')
            ->where('purpose', 'like' , '%grower%')
            ->get();

        $growersSelect = [];
        foreach($growers as $grower) {
            $growersSelect[$grower->id] = $grower->community_name;
        }
        $growers = $growersSelect;

        return view('find_growers', compact('growers'));
    }

    public function postIndex(Request $request)
    {
        $chat = new Chat();
        $chat->message = 'I want you to be my Grower. Please contact me back';

        if($request->has('seller_id')) {
            $chat->seller_id = $request->input('seller_id');
            $chat->seeker_id = auth()->user()->id;
        }

        $chat->sender_id = auth()->user()->id;
        $chat->save();

        return redirect()->back()->with('message', 'Thank you. Your grower has been notified');
    }

//    public function postIndex(Request $request)
//    {
//        $this->validate($request,[
//            'name' => 'required',
//            'email' => 'required|email',
//            'message' => 'required'
//        ]);
//
//        $mjexUsers = User::all();
//        $bcc = [];
//        foreach($mjexUsers as $mjexUser){
//            if($mjexUser->type=="seller" && has_purpose('grower',$mjexUser)) {
//                $bcc[] = $mjexUser->email;
//            }
//        }
//
//        $user['subject'] = $request->input('subject','Patient to Grower');
//        $user['message'] = $request->input('message','');
//        $user['name'] = $request->input('name','');
//        $user['email'] = $request->input('email','');
//
//        Mail::send('emails.find_growers', ['user' => $user], function ($m) use ($user, $bcc) {
//            $m->to($bcc)->subject('Patient to Grower: ' . $user['subject']);
//        });
//
//        return redirect()->back()->with('message','Message sent');
//    }
}
