<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\BannerAd;
use Mjex\Http\Requests;

class AdNetworkController extends Controller
{
    /**
     * Display ad network view
     */
    public function getIndex()
    {
        $bannerTypes = [
            [
                'placement' => 'home_header',
                'title' => '<strong>Home header</strong> <br> Size 468 x 60',
                'price_title' => '$30 for 1 mongth',
                'slot' => 1
            ],
            [
                'placement' => 'sidebar_left',
                'title' => '<strong>Sidebar left</strong> <br> Size 468 x 60',
                'price_title' => '$30 for 1 mongth',
                'slot'=>1
            ],
            [
                'placement' => 'sidebar_right',
                'title' => '<strong>Sidebar right</strong> <br> Size 468 x 60',
                'price_title' => '$30 for 1 mongth',
                'slot'=>1
            ],
        ];
        $bannerTypes = array_to_object($bannerTypes);
        foreach($bannerTypes as $type) {
        }
        return view('ad_network', compact('bannerTypes'));
    }

    /**
     * Submit purchase ad banner
     */
    public function postIndex(Request $request)
    {
        $this->validate($request, [
            'banner_type' => 'required',
        ]);
//        return $request->all();

        $banner = new BannerAd;

        $destinationPath = 'uploads/banner';
        if($request->hasFile('image')) {
            $galleries = [];
            $files = $request->file('image');
            foreach($files as $file) {
                if(!$file) continue;
                $fileName = $file->getClientOriginalName();
                $fileNameArr = explode('.', $fileName);
                $newFileName = $fileNameArr[0] . strtotime('now') . '.' . $fileNameArr[1]; // add timestamp
                $newFileName = preg_replace('/\s+/', '', $newFileName); //strip space
                $file->move($destinationPath, $newFileName);

                $galleries[] = implode('/', [$destinationPath, $newFileName]);
            }
            $banner->image = $galleries[0];
        }

        $banner->placement = $request->input('banner_type');
        $banner->user_id = auth()->user()->id;

        $banner->save();

        return redirect()->back()->with('message','Thank you for your purchase. We just sent you an email for further instruction. Please check your email as soon as you can.');
    }
}
