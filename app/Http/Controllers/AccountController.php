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
        $contactedUsers = $contactedUserIds = [];

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

    public function postRequestReview(Request $request)
    {
        $status = 'ok'; $msg = '';
        $orderId = $request->input('order_id');
        $order = Order::find($orderId);

        if(!is_null($order)) {
            $msg = 'Can you leave a feedback on my seller page: <a href="'. route('review.write') .'?order_id='. $orderId .'&token='. \Hash::make($orderId) .'">Leave a feedback</a>';

            $chat = new Chat();
            $chat->message = $msg;

            $chat->seller_id = $order->seller_id;
            $chat->seeker_id = $order->seeker_id;

            $chat->sender_id = $order->seller_id;
            $chat->save();
        }

        return response()->json([
            'status' => $status,
            'message' => $msg
        ]);
    }

    /**
     * Save profile
     * @param Request $request
     */
    public function putIndex(Request $request)
    {
        $this->validate($request,[
            'password' => 'min:6|confirmed',
            'email' => 'required',
//            'anonymous_email' => 'required|unique:users,anonymous_email,'.auth()->user()->id,
            'community_name' => '|required|unique:users,community_name,'.auth()->user()->id .'|regex:/(^[A-Za-z0-9]+$)+/',
            'zipcode' => 'required|numeric',
            'logo' => 'image'
        ],[
            'community_name.unique' => 'The username has already been taken.',
            'community_name.required' => 'The username is required.',
            'community_name.regex' => 'The username format is invalid.',
        ]);

        $user = User::find(auth()->user()->id);
        // $user->community_name = $request->input('community_name');
        $user->zipcode = $request->input('zipcode');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->delivery = $request->input('delivery');
        $user->community_name = $request->input('community_name');
        // $user->anonymous_email = $request->input('anonymous_email');
        $user->email = $request->input('email');
        $user->accepted_payment = $request->input('accepted_payment');
        $user->patients_available = $request->input('patients_available');
        $user->medical_card_number = $request->input('medical_card_number');
        $user->desired_alotment = $request->input('desired_alotment');
        $user->lat = $request->input('lat');
        $user->lng = $request->input('lng');
        if($request->has('password')) {
            $user->password = \Hash::make($request->input('password'));
        }
        $user->purpose = json_encode($request->input('purpose'));

        $destinationPath = 'uploads';
        if($request->hasFile('logo')) {
            if($user->logo && file_exists($user->logo)) {
                unlink($user->logo);
            }
            $fileName = $request->file('logo')->getClientOriginalName();
            $fileNameArr = explode('.', $fileName);
            $newFileName = $fileNameArr[0] . strtotime('now') . '.' . $fileNameArr[1];
            $request->file('logo')->move($destinationPath, $newFileName);

            $user->logo = implode('/', [$destinationPath, $newFileName]);
        }

        if($request->hasFile('header')) {
            if($user->header && file_exists($user->header)) {
                unlink($user->header);
            }
            $fileName = $request->file('header')->getClientOriginalName();
            $fileNameArr = explode('.', $fileName);
            $newFileName = $fileNameArr[0] . strtotime('now') . '.' . $fileNameArr[1];
            $request->file('header')->move($destinationPath, $newFileName);

            $user->header = implode('/', [$destinationPath, $newFileName]);
        }

        if($user->save())
            return redirect()->back()->with('message','Saved');

        return redirect()->back()->with('message','Please try again');
    }

    public function getUpgrade()
    {
        if(auth()->user()->package == 'none') return redirect()->to('/')->with('message','Please register a Seller account to access Upgrade page');
        return view('upgrade');
    }

    public function postUpgrade(Request $request)
    {
        $this->validate($request, [
            'package' => 'required'
        ]);
        $package = $request->input('package');

        $user = User::find(auth()->user()->id);
        $user->package = $package;

        if($user->save()) {
            $msg = "Your account is upgraded";
        }else{
            $msg = "Can not save your info. Please contact us for more information";
        }

        return redirect()->back()->with('message',$msg);
    }
}
