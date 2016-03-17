<?php

namespace Mjex\Http\Controllers;

use Mjex\Http\Requests;
use Illuminate\Http\Request;
use Mjex\Ad;
use Mjex\Http\Controllers\Controller;
use Mjex\Repo\AdRepo;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdRepo $adRepo)
    {
        $latestAds = $adRepo->getLatestAds();

        return view('index', compact('latestAds'));
    }

    public function search(Request $request, AdRepo $adRepo)
    {
        $this->validate($request,[
            'keyword' => 'required',
//            'lat' => 'required',
        ],[
            'keyword.required' => 'Please enter keyword to search',
//            'lat.required' => 'You must choose your location'
        ]);

        $keyword = $request->input('keyword');
//        $lat = $request->input('lat');
//        $lng = $request->input('lng');

        $searchResults = $adRepo->search($keyword);

        $bannerAds = $adRepo->getBannerAds();

        return redirect()->back()->with(compact('searchResults','bannerAds'));
    }
}