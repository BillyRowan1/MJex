<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
use Mjex\Review;

class ReviewController extends Controller
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    public function postStore()
    {
        $this->validate($this->request,[
            'content' => 'required',
            'reviewer' => 'required',
            'seller_id' => 'required|numeric'
        ]);

        $review = new Review;
        $review->content = $this->request->input('content');
        $review->reviewer = $this->request->input('reviewer','');
        $review->user_id = $this->request->input('seller_id');

        $review->save();

        return redirect()->back()->with('message','Review sent');
    }
}
