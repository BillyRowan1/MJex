<?php

namespace Mjex\Repo;

use Mjex\BannerAd;

class BannerAdRepo{
    public function __construct(BannerAd $bannerAd)
    {
        $this->model = $bannerAd;
    }

    public function all()
    {
        $bannerAds = BannerAd::where('active',1)->with('bannerPlacement')->get();
        $result = [];
        foreach ($bannerAds as $bannerAd) {
            if($bannerAd->expired_date < strtotime('now')) {
                // is expired
                $bannerAd->active = 0;
                $bannerAd->save();
            }else{
                $result[] = $bannerAd;
            }
        }

        return $result;
    }
}