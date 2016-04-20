<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
use Mjex\Order;
use Mjex\Review;

class ReviewController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getWrite()
    {
        $orderId = $this->request->input('order_id');
        $token = $this->request->input('token'); // for check permission

        if(Hash::check($orderId, $token)) {
            return view('leave_review', compact('orderId'));
        }

        abort(404);
    }

    public function postStore()
    {
        $this->validate($this->request,[
            'content' => 'required',
            'order_id' => 'required|numeric'
        ]);

        $order = Order::find($this->request->input('order_id'));

        $review = new Review;
        $review->content = $this->request->input('content');
        $review->reviewer = $order->seeker->community_name;
        $review->user_id = $order->seller_id;

        $review->save();

        return redirect()->back()->with('message','Review saved');
    }
}
