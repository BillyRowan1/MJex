<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Ad;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
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
        $ads = Ad::where('user_id', $seller->id)->get();

        return view('cart', compact('seller','ads'));
    }
}
