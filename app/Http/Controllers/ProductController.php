<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;
use Mjex\Http\Requests;
use Guzzle;
use Cart;

class ProductController extends Controller
{
    public function getIndex(Request $request)
    {
        try{
            $page = $request->input('page', 1);
            $nextPage = $page + 1;
            $productsRaw = Guzzle::get('https://www.cannabisreports.com/api/v1.0/products?sort=-updatedAt&page='.$page);
            $productsRaw = (string) $productsRaw->getBody();
            $products = json_decode($productsRaw, true)['data'];

            return view('products', compact('products','nextPage'));
        }catch(\Exception $e){
            echo 'API rate limit exceeded';
        }
    }

    public function postAddToCart(Request $request)
    {
        Cart::instance('products')->add($request->input('id'), $request->input('name'), 1,0);

        return view('partials.product_cart');
    }

    public function postRemoveFromCart(Request $request)
    {
        Cart::instance('products')->remove($request->input('rowid'));

        return view('partials.product_cart');
    }

    public function postCheckout(Request $request)
    {
        // Send order to admin
        \Mail::send('emails.product_order', [], function ($m) {
            $m->to(config('mail.contact'))->subject('Cannabis Product order from Seeker');
        });
        Cart::instance('products')->destroy();
        return '';
    }
}
