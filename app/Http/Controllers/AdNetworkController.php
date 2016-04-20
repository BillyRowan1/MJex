<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Http\Requests;

class AdNetworkController extends Controller
{
    public function getIndex()
    {
        return view('ad_network');
    }
}
