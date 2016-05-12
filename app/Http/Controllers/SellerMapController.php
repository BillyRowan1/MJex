<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Http\Requests;
use Mjex\User;

class SellerMapController extends Controller
{
    public function getStores()
    {
        $sellers = User::where('type', 'seller')->get();

        $stores = [];

        foreach($sellers as $seller) {
            $marker = [
                'title' => $seller->community_name . ' store',
                'address' => $seller->state . ', ' . $seller->zipcode . ', ' . $seller->country,
                'lat' => $seller->lat,
                'lng' => $seller->lng,
                'seller_id' => $seller->id,
            ];
            $seller->purpose = json_decode($seller->purpose);
            if(count($seller->purpose) > 0) {
                $marker['icon'] = '/img/marker/' . $seller->purpose[0] . '.png';
            }else{
                $marker['icon'] = '';
            }

            $stores[] = $marker;
        }

        return $stores;
    }
}
