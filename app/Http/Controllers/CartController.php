<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Cart;
use Mjex\Ad;
use Mjex\Chat;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
use Mjex\Order;
use Mjex\User;

class CartController extends Controller
{
    public function getIndex(Request $request)
    {
//        return Cart::content();

        $this->validate($request,[
            'seller_id' => 'required|numeric'
        ]);

        $seller = User::where('id', $request->input('seller_id'))->where('type','seller')->first();
        if(is_null($seller)) return redirect()->back();
        if($seller->purpose) $seller->purpose = json_decode($seller->purpose);

        $ads = Ad::where('user_id', $seller->id)->get();
        $chats = null;

        if(auth()->user() && auth()->user()->type == 'seeker') {
            $chats = Chat::where('seller_id', $seller->id)->where('seeker_id', auth()->user()->id)->orderBy('created_at','desc')->get();
        }

        return view('cart', compact('seller','ads','chats'));
    }

    public function postAddToCart(Request $request)
    {
        Cart::add([
            'id' => $request->input('id'),
            'name' => $request->input('product') . ' / ' .$request->input('strain'),
            'qty' => $request->input('qty'),
            'price' => $request->input('price'),
        ]);

        return view('inc.carts');
    }

    public function postUpdateQty(Request $request)
    {
        Cart::update($request->input('rowId'),[
            'qty' => $request->input('qty')
        ]);

        return view('inc.carts');
    }

    public function postDelete(Request $request)
    {
        Cart::remove($request->input('rowId'));

        return view('inc.carts');
    }

    public function postSendOrder(Request $request)
    {
        $seller = User::find($request->input('seller_id'));

        foreach(Cart::content() as $cartItem){
            $order = new Order;
            $order->qty = $cartItem->qty;
            $order->desc = $cartItem->name;
            $order->price = $cartItem->price;
            $order->seeker_id = auth()->user()->id;
            $order->seller_id = $request->input('seller_id');
            $order->price = $cartItem->price;

            $order->save();
        }

        \Mail::send('emails.order',['seller'=>$seller,'buyer'=>auth()->user()], function ($m) use ($seller){
            $m->to($seller->email)->subject('Mjex order');
        });

        return redirect()->back();
    }

    public function postClearCart()
    {
        Cart::destroy();
    }

    public function postSendMessageToGrower(Request $request)
    {
        $this->validate($request,[
            'msg' => 'required',
            'grower_email' => 'required'
        ],[
            'msg.required' => 'You must enter your message to this grower'
        ]);
        $msg = $request->input('msg');
        $growerEmail = $request->input('grower_email');

        \Mail::send('emails.msg_to_grower',['msg'=>$msg], function ($m) use ($growerEmail){
            $m->to($growerEmail)->subject('Message from Seeker');
        });

        return redirect()->back()->with('message','Your message has been sent');
    }
}
