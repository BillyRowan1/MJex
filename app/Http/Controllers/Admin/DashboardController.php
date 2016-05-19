<?php

namespace Mjex\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Mjex\BannerAd;
use Mjex\BannerPlacement;
use Mjex\User;
use Mjex\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    /**
     * Display admin dashboard
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getIndex()
    {
        $users = User::orderBy('created_at','desc')->get();

        return view('admin.dashboard', compact('users'));
    }

    public function getAdNetwork()
    {
        $bannerPlacements = BannerPlacement::orderBy('created_at','desc')->get();
        $bannerAds = BannerAd::orderBy('created_at','desc')->get();

        return view('admin.adnetwork', compact('bannerPlacements','bannerAds','users'));
    }

    /**
     * Change banner placement info
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putIndex(Request $request)
    {
        $bannerPlacement = BannerPlacement::find($request->input('id'));

        $bannerPlacement->price = $request->input('price');
        $bannerPlacement->title = $request->input('title');
        $bannerPlacement->max_slot = $request->input('max_slot');
        $bannerPlacement->save();

        return redirect()->back()->with('message','Saved');
    }

    /**
     * Change purchased Banner Ad info
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putBannerAds(Request $request) {
        $bannerAd = BannerAd::find($request->input('id'));

        if($request->has('active')) $bannerAd->active = $request->input('active');
        $bannerAd->save();

        return redirect()->to('mjexadmin#tabBannerAds')->with('message','Saved');
    }

}
