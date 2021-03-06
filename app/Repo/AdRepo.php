<?php

namespace Mjex\Repo;

use Mjex\Ad;

class AdRepo{
    public function __construct(Ad $ad)
    {
        $this->model = $ad;
    }

    public function getTotalAd($userId, $count = true)
    {
        if($count) {
            return $this->model->where('user_id', $userId)->count();
        }else{
            return $this->model->where('user_id', $userId)->get();
        }
    }

    public function getLatestAds($limit = 10)
    {
        $latestAds = $this->model->orderBy('ad_type','desc')->where('active',1)->limit($limit)->with('user')->get();
        $latestAds = $this->sortPaidFirst($latestAds);

        $result = [];
        foreach($latestAds as $ad) {
            if($ad->category == 'adult_use') {
                $result['Adult use'][] = $ad;
            }
            if($ad->category == 'medical') {
                $result['Medical'][] = $ad;
            }
            if($ad->category == 'other') {
                $result['Other business'][] = $ad;
            }
        }

        return $result;
    }

    public function search($keyword, $adCreatedBy, $lat = 0, $lng = 0)
    {
        if(empty($adCreatedBy)) {
            $searchResults = $this->model->search($keyword)
                ->with('user')
                ->where('active',1)
                ->where('expired_date','>',strtotime('now'))
                ->get();
        }else{
            $searchResults = $this->model->search($keyword)
                ->where('expired_date','>',strtotime('now'))
                ->leftJoin('users','users.id','=','ads.user_id')
                ->where('users.purpose','like','%'.$adCreatedBy.'%')
                ->where('users.active',1)
                ->with('user')
                ->get();
        }

        // Sort by distance first
        if($lat != 0) {
            foreach($searchResults as &$ad) {
                if($ad->user->lat && $ad->user->lng) {
                    $ad->distance = distance($lat, $lng, $ad->user->lat, $ad->user->lng);
                }else{
                    $ad->distance = 10000000000; // far far away
                }
            }

            $searchResultsArr = json_decode(json_encode($searchResults));

            usort($searchResultsArr, function($a, $b)
            {
                if ($a->distance == $b->distance) {
                    return 0;
                }
                return ($a->distance < $b->distance) ? -1 : 1;
            });
            $searchResults = $searchResultsArr;
        }

        // Sort result by priority: paid ad > free ad, paid user > free user
        $searchResults = $this->sortPaidFirst($searchResults);

        $result = [];
        if($ad->category == 'adult_use') {
            $result['Adult use'][] = $ad;
        }
        if($ad->category == 'medical') {
            $result['Medical'][] = $ad;
        }
        if($ad->category == 'other') {
            $result['Other business'][] = $ad;
        }

        return $result;
    }

    public function getBannerAds($lat = 0, $lng = 0, $unit = "m")
    {
//        $radius = 15000;
//        $radius = (double) $radius;
//
//        $unit = ($unit === "km") ? 6378.10 : 3963.17;

        $ads = \DB::table('ads')
            ->leftJoin('users', 'users.id', '=', 'ads.user_id')
            ->select('ads.*', 'users.package')
//            ->having('distance','<=',$radius)
//            ->select(\DB::raw("ads.id, ads.user_id, ads.thumb, ads.content,
//                            ($unit * ACOS(COS(RADIANS($lat))
//                                * COS(RADIANS(users.lat))
//                                * COS(RADIANS($lng) - RADIANS(users.lng))
//                                + SIN(RADIANS($lat))
//                                * SIN(RADIANS(users.lat)))) AS distance")
//            )
            ->where('expired_date','>',strtotime('now'))
            ->where('users.package', 'weekly_pro')
//            ->orderBy('distance','asc')
            ->orderBy('ads.created_at','desc')
            ->limit(5)
            ->get();

        return $ads;
    }

    private function sortPaidFirst($ads)
    {
        foreach($ads as $ad) {
            if($ad->user && $ad->user->reviews) {
                $ad->user->reviews = $ad->user->reviews;
            }
        }
        // Sort result by priority: paid ad > free ad, paid user > free user
        $ads = object_to_array($ads);
        usort($ads, function($a, $b) {
            if($a['ad_type'] == $b['ad_type']) {
                if ($a['user']['package'] == $a['user']['package']) {
                    return 0;
                }elseif($a['user']['package'] == 'weekly_pro') {
                    return -1;
                }else{
                    return 1;
                }
            }elseif($a['ad_type'] == 'free'){
                return 1;
            }else{
                return -1;
            }
        });
        $ads = array_to_object($ads);

        return $ads;
    }

}