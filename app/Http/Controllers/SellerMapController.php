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
            if(!empty($seller->logo)) {
                $marker['icon'] = url($seller->logo);
            }else{
                $marker['icon'] = '';
            }

            $stores[] = $marker;
        }

        return $stores;
    }
}
