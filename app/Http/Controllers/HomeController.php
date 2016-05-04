<?php

namespace Mjex\Http\Controllers;

use Mjex\Http\Requests;
use Illuminate\Http\Request;
use Mjex\Ad;
use Mjex\Http\Controllers\Controller;
use Mjex\Repo\AdRepo;
use Mjex\Repo\UserRepo;
use Mjex\BannerAd;
use Mjex\User;
use Mjex\Repo\BannerAdRepo;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(AdRepo $adRepo, UserRepo $userRepo, BannerAdRepo $bannerAdRepo)
    {
        $latestAds = $adRepo->getLatestAds();
        $latestGrowers = $userRepo->getRecentGrower();
        $bannerAds = $bannerAdRepo->all();

        return view('index', compact('latestAds','latestGrowers','bannerAds'));
    }

    public function search(Request $request, AdRepo $adRepo, UserRepo $userRepo)
    {
        $this->validate($request,[
            'keyword' => 'required',
        ],[
            'keyword.required' => 'Please enter keyword to search',
        ]);

        $keyword = $request->input('keyword');
        $adCreatedBy = $request->input('ad_created_by');
        $lat = $request->input('lat',0);
        $lng = $request->input('lng',0);

        $searchResults = $adRepo->search($keyword, $adCreatedBy, $lat, $lng);
        $growerResults = $userRepo->searchGrower($keyword);

        $bannerAds = $adRepo->getBannerAds();

        return redirect()->back()->with(compact('searchResults','growerResults','bannerAds'));
    }
}