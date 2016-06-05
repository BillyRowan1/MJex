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
        $this->validate($request,[
            'seller_id' => 'required|numeric'
        ]);

        $seller = User::where('id', $request->input('seller_id'))->where('type','seller')->first();
        if(is_null($seller)) return redirect()->back();
        if($seller->purpose) $seller->purpose = json_decode($seller->purpose);

        $ads = Ad::where('user_id', $seller->id)->orderby('created_at','desc')->get();
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

    public function postSelectAsMyGrower(Request $request)
    {
        $this->validate($request,[
            'grower_id' => 'required',
            'seeker_id' => 'required'
        ]);

        $grower = User::find($request->input('grower_id'));
        $seeker = User::find($request->input('seeker_id'));

        if($grower && $seeker) {
            \Mail::send('emails.grower_request',compact('grower','seeker'), function ($m) use ($grower){
                $m->to($grower->email)->subject('A Grower Request');
            });
        }

        return redirect()->back()->with('message','Your request has been sent to this Grower');
    }
}
