<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Chat;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;

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
        if($this->request->has('seller_id')) {
            $chat->seller_id = $this->request->input('seller_id');
            $chat->seeker_id = auth()->user()->id;
        }
        if($this->request->has('seeker_id')) {
            $chat->seeker_id = $this->request->input('seeker_id');
            $chat->seller_id = auth()->user()->id;
        }
        $chat->sender_id = auth()->user()->id;
        $chat->save();
        $status = 'ok';

        return response()->json(compact('status'));
    }
}
