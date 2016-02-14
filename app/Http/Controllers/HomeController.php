<?php

namespace Mjex\Http\Controllers;

use Mjex\Http\Requests;
use Illuminate\Http\Request;
use Mjex\Ad;
use Mjex\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

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
}
