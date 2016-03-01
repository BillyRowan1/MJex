<?php

namespace Mjex\Http\Controllers;

use Illuminate\Http\Request;

use Mjex\Ad;
use Mjex\Http\Requests;
use Mjex\Http\Controllers\Controller;
use Mjex\Repo\UserRepo;
use Mjex\User;

class AdController extends Controller
{
    public function __construct()
    {
        $this->middleware('seller');
    }
    public function getCreateFree()
    {
        $adsThisMonth = $this->getAdsThisMonth('count');

        switch(auth()->user()->package) {
            case 'free':
                $adsLeft = 1 - $adsThisMonth;
                break;
            case 'monthly':
                $adsLeft = 5 - $adsThisMonth;
                break;
            case 'monthly_pro':
                $adsLeft = 5 - $adsThisMonth;
                break;
        }

        return view('post_free_ad', compact('adsLeft'));
    }

    public function getCreatePaid(UserRepo $userRepo)
    {
        $zipcodes = $userRepo->getAllZipcode();

        return view('post_paid_ad', compact('zipcodes'));
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
        if($this->getAdsThisMonth('count') < 1) {
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
            $ad->ad_type = $type;
            if($request->has('price_per_quantity')) {
                $ad->price_per_quantity = json_encode($request->input('price_per_quantity'));
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
        }else{
            $msg = "Can't create more than 1 free ad per month. Please wait until next month or create a " . "<a href='". route('ad.create.paid') ."'>Paid ad</a>";
        }
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
        if($ad->delete()){
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
}
