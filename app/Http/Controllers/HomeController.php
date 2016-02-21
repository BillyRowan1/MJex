<?php

namespace Mjex\Http\Controllers;

use Mjex\Http\Requests;
use Illuminate\Http\Request;
use Mjex\Ad;
use Mjex\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latestAds = Ad::orderBy('created_at','desc')->limit(10)->get();
        return view('index', compact('latestAds'));
    }

    public function search(Request $request)
    {
        $this->validate($request,[
            'zipcode' => 'required|numeric',
            'keyword' => 'required'
        ]);

        $query = $request->input('keyword');

        $latestAds = Ad::orderBy('created_at','desc')->limit(10)->get();
        $searchResults = Ad::search($query)
            ->with('user')
            ->get();

        return view('index', compact('searchResults','latestAds'));
    }
}