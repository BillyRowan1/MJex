<?php

namespace Mjex\Repo;

use Mjex\Ad;

class AdRepo{
    public function __construct(Ad $ad)
    {
        $this->model = $ad;
    }

    public function getLatestAds($limit = 10)
    {
        return $this->model->orderBy('updated_at','desc')->where('active',1)->limit($limit)->get();
    }

    public function search($keyword, $lat = 0, $lng = 0)
    {
        $searchResults = $this->model->search($keyword)
            ->with('user')
            ->where('active',1)
            ->where('expired_date','>',strtotime('now'))
            ->get();

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

        return $searchResults;
    }

    public function getBannerAds($lat = 0, $lng = 0, $unit = "m")
    {
        $radius = 15000;
        $radius = (double) $radius;

        $unit = ($unit === "km") ? 6378.10 : 3963.17;

        $ads = \DB::table('ads')
            ->leftJoin('users', function($join)
            {
                $join->on('users.id', '=', 'ads.user_id')
                    ->where('users.package', '=', 'monthly_pro');
            })
            ->having('distance','<=',$radius)
            ->select(\DB::raw("ads.id, ads.user_id, ads.thumb, ads.content,
                            ($unit * ACOS(COS(RADIANS($lat))
                                * COS(RADIANS(users.lat))
                                * COS(RADIANS($lng) - RADIANS(users.lng))
                                + SIN(RADIANS($lat))
                                * SIN(RADIANS(users.lat)))) AS distance")
            )
            ->where('expired_date','>',strtotime('now'))
            ->orderBy('distance','asc')
            ->limit(5)
            ->get();

        return $ads;
    }

}