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
        ],[
            'keyword.required' => 'Please enter keyword to search',
        ]);

        $keyword = $request->input('keyword');
        $adCreatedBy = $request->input('ad_created_by');

        $searchResults = $adRepo->search($keyword, $adCreatedBy);

        $bannerAds = $adRepo->getBannerAds();

        return redirect()->back()->with(compact('searchResults','bannerAds'));
    }
}