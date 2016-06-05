<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;
use Mjex\Http\Requests;
use Guzzle;

class DispensaryController extends Controller
{
    public function getIndex(Request $request)
    {
        $page = $request->input('page', 1);
        $nextPage = $page + 1;
        $response = Guzzle::get('https://www.cannabisreports.com/api/v1.0/dispensaries?page='.$page);
        $response = (string)($response->getBody());
        $meta = json_decode($response,true)['meta'];
        $data = json_decode($response)->data;

        return view('dispensaries', compact('data','nextPage','meta'));
    }

    public function getDetail($state, $city, $slug)
    {
        try{
            $response = Guzzle::get('https://www.cannabisreports.com/api/v1.0/dispensaries/'.$state.'/'.$city.'/'.$slug);
            $response = (string)($response->getBody());
            $dispensary = json_decode($response, true);
            $dispensary = $dispensary['data'];

            $flowersRaw = Guzzle::get($dispensary['flowers']['link']);
            $flowersRaw = (string) $flowersRaw->getBody();
            $flowers = json_decode($flowersRaw, true)['data'];

            $extractsRaw = Guzzle::get($dispensary['extracts']['link']);
            $extractsRaw = (string) $extractsRaw->getBody();
            $extracts = json_decode($extractsRaw, true)['data'];

            $ediblesRaw = Guzzle::get($dispensary['edibles']['link']);
            $ediblesRaw = (string) $ediblesRaw->getBody();
            $edibles = json_decode($ediblesRaw, true)['data'];

            $productsRaw = Guzzle::get($dispensary['products']['link']);
            $productsRaw = (string) $productsRaw->getBody();
            $products = json_decode($productsRaw, true)['data'];

            return view('dispensaries_detail', compact('dispensary','flowers','extracts','edibles','products'));
        }catch(\Exception $e){
            echo 'API rate limit exceeded';
        }

    }

    public function postItems(Request $request)
    {
        $link = $request->input('link');
        $type = $request->input('type');
        $itemsRaw = Guzzle::get($link);
        $itemsRaw = (string) $itemsRaw->getBody();
        $items = json_decode($itemsRaw, true)['data'];

        return view('partials.'.$type.'_row', [$type => $items]);
    }
}
