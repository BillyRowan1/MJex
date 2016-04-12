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

    /**
     * Save profile
     * @param Request $request
     */
    public function putIndex(Request $request)
    {
        $this->validate($request,[
            'password' => 'min:6',
            'anonymous_email' => 'required|unique:users,anonymous_email,'.auth()->user()->id,
            'community_name' => 'required|unique:users,community_name,'.auth()->user()->id,
            'zipcode' => 'required|numeric',
            'logo' => 'image'
        ]);

        $user = User::find(auth()->user()->id);
        $user->community_name = $request->input('community_name');
        $user->zipcode = $request->input('zipcode');
        $user->state = $request->input('state');
        $user->country = $request->input('country');
        $user->delivery = $request->input('delivery');
        $user->anonymous_email = $request->input('anonymous_email');
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
            $fileName = $request->file('logo')->getClientOriginalName();
            $fileNameArr = explode('.', $fileName);
            $newFileName = $fileNameArr[0] . strtotime('now') . '.' . $fileNameArr[1];
            $request->file('logo')->move($destinationPath, $newFileName);

            $user->logo = implode('/', [$destinationPath, $newFileName]);
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
