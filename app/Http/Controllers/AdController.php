<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Ad;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
use Mjex\Repo\AdRepo;
use Mjex\Repo\UserRepo;
use Mjex\User;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }

    public function getCreateBanner()
    {

    }

    public function getCreateFree(AdRepo $adRepo)
    {
        $adsThisWeek = $this->getAdsThisWeek('count');
//        $adsLeft = 0;

        switch(auth()->user()->package) {
            case 'free':
                $adsLeft = 1 - $adRepo->getTotalAd(auth()->user()->id);
                break;
            case 'weekly':
                $adsLeft = 1 - $adsThisWeek;
                break;
            case 'weekly_pro':
                $adsLeft = 1 - $adsThisWeek;
                break;
        }
        if($adsLeft < 0) $adsLeft = 0;
        return view('post_free_ad', compact('adsLeft'));
    }

    public function getCreatePaid(UserRepo $userRepo)
    {
        $zipcodes = $userRepo->getAllZipcode();

        return view('post_paid_ad', compact('zipcodes'));
    }

    public function getEdit(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);

        $ad = Ad::find($request->input('id'));
        $ad->gallery = !empty($ad->gallery)?json_decode($ad->gallery):[];

        return view('edit_ad', compact('ad'));
    }

    public function postUpdate(Request $request)
    {
        $this->validate($request, [
            "type_of_product" => "required",
            "unit_available" => "required",
            "amount" => "required",
            "header_color" => "required",
            "description" => "required",
            "price_per_unit" => "",
            "adContent" => "required",
            "thumb" => 'image'
        ]);
        $ad = Ad::find($request->input('id'));

        $ad->type_of_product = $request->input('type_of_product');
        $ad->unit_available = $request->input('unit_available');
        $ad->amount = $request->input('amount');
        $ad->header_color = $request->input('header_color');
        $ad->description = $request->input('description');
        $ad->price_per_unit = $request->input('price_per_unit');

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

        if(auth()->user()->package == 'free') {
            $ad->content = strip_tags($request->input('adContent'));
        }else{
            $ad->content = $request->input('adContent');
        }

        if($ad->save()) {
            $msg = 'Ad updated';
        }else{
            $msg = 'Can not update ad, please try again';
        }

        return redirect()->back()->with('message',$msg);
    }

    public function postStoreFree(Request $request)
    {
        $msg = $this->store($request, 'free');

        return redirect()->back()->with('message', $msg);
    }

    public function postStorePaid(Request $request)
    {
        $msg = $this->store($request, 'paid');

        return redirect()->back()->with('message', $msg);
    }

    private function store($request, $type = 'free')
    {
        // Condition: Each package only have 1 ad per package.
        // First check if this user have 1 free ad this month
            $this->validate($request, [
                "type_of_product" => "required",
                "unit_available" => "required",
                "amount" => "required",
                "header_color" => "required",
                "description" => "required",
                "price_per_unit" => "numeric",
                "adContent" => "required",
                "thumb" => 'image'
            ]);

            $ad = new Ad;
            $ad->user_id = auth()->user()->id;
            $ad->type_of_product = $request->input('type_of_product');
            $ad->unit_available = $request->input('unit_available');
            $ad->amount = $request->input('amount');
            $ad->header_color = $request->input('header_color');
            $ad->description = $request->input('description');
            $ad->price_per_unit = $request->input('price_per_unit');
            $ad->ad_type = $type;
            $ad->active = 1;
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

            if($type == "paid") {
                $user = User::find(auth()->user()->id);
                // Charge $2 per paid ad
                $user->charge(200);
            }
            if(auth()->user()->package == 'free') {
                $ad->content = strip_tags($request->input('adContent'));
            }else{
                $ad->content = $request->input('adContent');
            }

            if($ad->save()) {
                $msg = 'Ad created';
            }else{
                $msg = 'Can not create ad, please try again';
            }

        return $msg;
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

    public function postDestroy(Request $request)
    {
        $this->validate($request,[
            'id' => 'required'
        ]);

        $id = $request->input('id');
        $ad = Ad::find($id);
        $ad->active = 0;

        if($ad->save()){
            return response()->json(['status'=>'ok']);
        }else{
            return response()->json(['status'=>'failed']);
        }
    }

    private function getAdsThisMonth($action)
    {
        $query = Ad::where('user_id', auth()->user()->id)
                    ->where('ad_type','free')
                    ->where( \DB::raw('MONTH(created_at)'), '=', date('n') );
        if($action == 'count') {
            $adThisMonth = $query->count();
        }else{
            $adThisMonth = $query->get();
        }

        return $adThisMonth;
    }

    private function getAdsThisWeek($action)
    {
        $query = Ad::where('user_id', auth()->user()->id)
            ->where('ad_type','free')
            ->where( \DB::raw('WEEK(created_at)'), '=', date('W') );
        if($action == 'count') {
            $adThisMonth = $query->count();
        }else{
            $adThisMonth = $query->get();
        }

        return $adThisMonth;
    }
}
