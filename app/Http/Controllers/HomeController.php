<?php

namespace Mjex\Http\Controllers;

use Mjex\Http\Requests;
use Illuminate\Http\Request;
use Mjex\Ad;
use Mjex\Http\Controllers\Controller;
use Mjex\Repo\AdRepo;
use Mjex\User;

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
        $growers = User::where('type', 'seller')
            ->where('purpose', 'like' , '%grower%')
            ->where('active', 1)
            ->where('patients_available','>',0)
            ->get();

        $growersSelect = [''=>'none'];
        foreach($growers as $grower) {
            $growersSelect[$grower->id] = $grower->community_name;
        }
        $growers = $growersSelect;

        return view('index', compact('latestAds','growers'));
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
        $growerId = $request->input('grower_id');
        $lat = $request->input('lat',0);
        $lng = $request->input('lng',0);

        if($adCreatedBy == 'grower') {
            $searchResults = $adRepo->search($keyword, $adCreatedBy, $lat, $lng, $growerId);
        }else{
            $searchResults = $adRepo->search($keyword, $adCreatedBy, $lat, $lng);
        }

        $bannerAds = $adRepo->getBannerAds();

        return redirect()->back()->with(compact('searchResults','bannerAds'));
    }
}