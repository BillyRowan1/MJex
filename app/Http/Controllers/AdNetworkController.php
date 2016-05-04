<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\BannerAd;
use Mjex\BannerPlacement;
use Mjex\Http\Requests;

class AdNetworkController extends Controller
{
    /**
     * Display ad network view
     */
    public function getIndex()
    {
        $bannerPlacements = BannerPlacement::all();

        foreach($bannerPlacements as $bannerPlacement) {
            // Update available slot
            $bannerPlacement->slot = $bannerPlacement->max_slot - BannerAd::where('placement_id', $bannerPlacement->id)->count();
        }
        
        return view('ad_network', compact('bannerPlacements'));
    }

    /**
     * Submit purchase ad banner
     */
    public function postIndex(Request $request)
    {
        $this->validate($request, [
            'placement_id' => 'required',
        ]);

        $banner = new BannerAd;
        $bannerPlacement = BannerPlacement::find($request->input('placement_id'));
        $slot = $bannerPlacement->max_slot - BannerAd::where('placement_id', $bannerPlacement->id)->count();

        if($slot > 0 && $request->hasFile('image')) {
            $destinationPath = 'uploads/banner';
            $file = $request->file('image');
            $fileName = $file->getClientOriginalName();
            $fileNameArr = explode('.', $fileName);
            $newFileName = $fileNameArr[0] . strtotime('now') . '.' . $fileNameArr[1]; // add timestamp
            $newFileName = preg_replace('/\s+/', '', $newFileName); //strip space
            $file->move($destinationPath, $newFileName);

            $banner->image = implode('/', [$destinationPath, $newFileName]);

            $banner->placement_id = $request->input('placement_id');
            $banner->user_id = auth()->user()->id;
            $banner->expired_date = strtotime('now') + 30*86400;
            $banner->active = 1;

            $banner->save();
        }else{
            return redirect()->back()->with('error',"This Banner doesn't have any slot left");
        }

        return redirect()->back()->with('message','Thank you for your purchase.');
    }
}
