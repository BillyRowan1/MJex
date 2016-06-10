<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Http\Requests;
use Mjex\User;
use GuzzleCache;

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
                'link' => url('cart?seller_id='.$seller->id)
            ];
            $seller->purpose = json_decode($seller->purpose);
            if(count($seller->purpose) > 0) {
                $marker['icon'] = '/img/marker/' . $seller->purpose[0] . '.png';
            }else{
                $marker['icon'] = '';
            }

            $stores[] = $marker;
        }

        // Dispensaries
        $client = GuzzleCache::client();
        $response = $client->get('https://www.cannabisreports.com/api/v1.0/dispensaries');
        $response = (string)($response->getBody());
        $meta = json_decode($response, true)['meta'];
        $dispensaries = json_decode($response)->data;

        foreach($dispensaries as $dispensary) {
            $marker = [
                'title' => $dispensary->name,
                'address' => $dispensary->address->address1,
                'lat' => $dispensary->lat,
                'lng' => $dispensary->lng,
                'icon' => '',
                'link' => url('dispensaries/detail/' . $dispensary->slug),
            ];

            $stores[] = $marker;
        }

        $maxPage = $meta['pagination']['total_pages'];
        if($maxPage > 10) $maxPage = 10;

        for($i = 2; $i <= $maxPage; $i++) {
            try{
                $response = $client->get('https://www.cannabisreports.com/api/v1.0/dispensaries?page='. $i);
                $response = (string)($response->getBody());
                $dispensaries = json_decode($response)->data;

                foreach($dispensaries as $dispensary) {
                    $marker = [
                        'title' => $dispensary->name,
                        'address' => $dispensary->address->address1,
                        'lat' => $dispensary->lat,
                        'lng' => $dispensary->lng,
                        'icon' => '',
                        'link' => url('dispensaries/detail/' . $dispensary->slug),
                    ];

                    $stores[] = $marker;
                }
            }catch(\Exception $e) {

            }
        }

        return $stores;
    }
}
