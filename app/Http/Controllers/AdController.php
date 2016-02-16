<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Ad;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;

class AdController extends Controller
{
    public function getCreateFree()
    {
        return view('post_free_ad');
    }

    public function getCreatePaid()
    {
        return view('post_paid_ad');
    }

    public function postStore(Request $request)
    {
        $this->validate($request, [
            "type_of_product" => "required",
            "unit_desc" => "required",
            "amount" => "required",
            "header_color" => "required",
            "location" => "required",
            "type_of_strain" => "required",
            "price_per_unit" => "",
            "price_per_quantity" => "",
            "adContent" => "required",
            "thumb" => 'image'
        ]);

        $ad = new Ad;
        $ad->user_id = auth()->user()->id;
        $ad->type_of_product = $request->input('type_of_product');
        $ad->unit_desc = $request->input('unit_desc');
        $ad->amount = $request->input('amount');
        $ad->header_color = $request->input('header_color');
        $ad->location = $request->input('location');
        $ad->type_of_strain = $request->input('type_of_strain');
        $ad->price_per_unit = $request->input('price_per_unit');
        if($request->has('price_per_quantity')) {
            $ad->price_per_quantity = json_encode($request->input('price_per_quantity'));
        }
        if($request->input('ad_type')=="free"){
            $ad->content = strip_tags($request->input('adContent'));
        }else{
            $ad->content = $request->input('adContent');
        }
        $ad->expired_date = strtotime('now') + 30*86400;

        $destinationPath = 'uploads';
        if($request->hasFile('thumb')) {
            $fileName = $request->file('thumb')->getClientOriginalName();
            $fileNameArr = explode('.', $fileName);
            $newFileName = $fileNameArr[0] . strtotime('now') . '.' . $fileNameArr[1];
            $request->file('thumb')->move($destinationPath, $newFileName);

            $ad->thumb = implode('/', [$destinationPath, $newFileName]);
        }

        if($request->hasFile('gallery')) {
            $galleries = [];
            $files = $request->file('gallery');
            foreach($files as $file) {
                if(!$file) continue;
                $fileName = $file->getClientOriginalName();
                $fileNameArr = explode('.', $fileName);
                $newFileName = $fileNameArr[0] . strtotime('now') . '.' . $fileNameArr[1];
                $file->move($destinationPath, $newFileName);

                $galleries[] = implode('/', [$destinationPath, $newFileName]);
            }
            $ad->gallery = json_encode($galleries);
        }

        if($ad->save()) {
            $msg = 'Ad created';
        }else{
            $msg = 'Can not create ad, please try again';
        }
        return redirect()->back()->with('message', $msg);
    }

    public function postRePost(Request $request)
    {
        $adId = $request->input('id');
        $ad = Ad::find($adId);
        $status = 'failed';
        if($ad) {
            $ad->expired_date = strtotime('now') + 30*86400;
            if($ad->save()){
                $status = 'ok';
                $msg = 'Ad reposted';
            }else{
                $msg = 'Can not repost ad, please try again';
            }
        }else{
            $msg = 'Could not find specified ad';
        }

        return response()->json(['status'=>$status, 'message'=>$msg]);
    }
}
