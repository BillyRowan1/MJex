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
            if(!empty($seller->lat) && !empty($seller->lng)) {
                $stores[] = [
                    'title' => $seller->community_name . ' store',
                    'lat' => $seller->lat,
                    'lng' => $seller->lng,
                    'seller_id' => $seller->id
                ];
            }
        }

        return $stores;
    }
}
