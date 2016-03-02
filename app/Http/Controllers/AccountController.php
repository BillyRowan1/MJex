<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Ad;
use Mjex\Chat;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
use Mjex\Order;
use Mjex\User;

class AccountController extends Controller
{
    public function getIndex()
    {
        $user = User::find(auth()->user()->id);
        if($user->purpose) $user->purpose = json_decode($user->purpose);

        $ads = Ad::where('user_id', $user->id)->where('active',1)->orderBy('created_at','desc')->get();
        $allMsg = Chat::where(auth()->user()->type . '_id', auth()->user()->id)->orderBy('created_at','desc')->get();
        $contactedUsers = [];

        foreach($allMsg as $msg){
            if(auth()->user()->type == 'seeker') {
                $contactedUserIds[] = $msg->seller_id;
            }else{
                $contactedUserIds[] = $msg->seeker_id;
            }
        }
        $contactedUserIds = array_unique($contactedUserIds);
        foreach($contactedUserIds as $id) {
            $contactedUsers[] = User::find($id);
        }
        foreach($contactedUsers as &$contactedUser){
            $messages = [];
            foreach($allMsg as $msg) {
                if($msg->seller_id == $contactedUser->id || $msg->seeker_id == $contactedUser->id) {
                    $messages[] = $msg;
                }
            }
            $contactedUser->messages = $messages;
        }

        $orders = Order::where($user->type . '_id', auth()->user()->id)->orderBy('created_at','desc')->get();

        return view('account', compact('user','ads','contactedUsers','allMsg','orders'));
    }

    /**
     * Save profile
     * @param Request $request
     */
    public function putIndex(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'min:6',
            'community_name' => 'required|unique:users,community_name,'.auth()->user()->id,
            'zipcode' => 'required|numeric',
        ]);
        $user = User::find(auth()->user()->id);
        $user->email = $request->email;
        $user->community_name = $request->input('community_name');
        $user->zipcode = $request->input('zipcode');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->accepted_payment = $request->input('accepted_payment');
        $user->lat = $request->input('lat');
        $user->lng = $request->input('lng');
        if($request->has('password')) $user->password = \Hash::make($user->password);
        if($request->has('purpose')) $user->purpose = json_encode($request->input('purpose'));

        if($user->save())
            return redirect()->back()->with('message','Saved');

        return redirect()->back()->with('message','Please try again');
    }
}
