<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Cart;
use Mjex\Ad;
use Mjex\Chat;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
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

    public function postSendOrder(Request $request)
    {
        $seller = User::find($request->input('seller_id'));

        // Send activation email
        \Mail::send('emails.order',[], function ($m) use ($seller){
            $m->to($seller->email)->subject('Mjex order');
        });
    }

    public function postClearCart()
    {
        Cart::destroy();
    }
}
