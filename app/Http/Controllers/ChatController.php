<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mail;
use Mjex\Chat;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
use Activity;
use Mjex\User;

class ChatController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function postStore()
    {
        $this->validate($this->request,[
            'message' => 'required',
        ]);

        $chat = new Chat();
        $chat->message = $this->request->input('message');
        if($this->request->has('seller_id') && $this->request->has('seeker_id')) {
            $chat->seller_id = $this->request->input('seller_id');
            $chat->seeker_id = $this->request->input('seeker_id');
        }else{
            if($this->request->has('seller_id')) {
                $chat->seller_id = $this->request->input('seller_id');
                $chat->seeker_id = auth()->user()->id;
            }
            if($this->request->has('seeker_id')) {
                $chat->seeker_id = $this->request->input('seeker_id');
                $chat->seller_id = auth()->user()->id;
            }    
        }
        
        $chat->sender_id = auth()->user()->id;
        $chat->save();
        $status = 'ok';

        if($chat->sender_id != $chat->seller_id) {
            // check if user is offline, send this message to that seller too
            $activities = \Activity::where('user_id', $chat->seller_id)->usersByMinutes(10)->count();  // Last 10 minutes
            \Log::info('User ' . $chat->seller_id . ' last activity: ' . $activities);
            if($activities == 0) {
                // user is offline
                $seller = User::find($chat->seller_id);
                $seeker = User::find($chat->seeker_id);
                $msg = $chat->message;

                Mail::send('emails.msg_to_grower', ['msg' => $msg], function ($m) use ($seller, $seeker) {
                    $m->from($seeker->community_name . '@mjex.co');
                    $m->to($seller->email)->subject('Chat message notification');
                });
            }
        }

        return response()->json(compact('status'));
    }
}
