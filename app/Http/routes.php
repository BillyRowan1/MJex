<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::post('stripe/webhook', '\Laravel\Cashier\WebhookController@handleWebhook');
//    Route::get('test',function(){
//        $zipcode="100000";
//        $country = strtoupper("us");
//        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=".$zipcode."&components=country:".$country."&sensor=false";
//        $details=file_get_contents($url);
//        $result = json_decode($details,true);
//
//        $lat=$result['results'][0]['geometry']['location']['lat'];
//
//        $lng=$result['results'][0]['geometry']['location']['lng'];
//
//        echo "Latitude :" .$lat;
//        echo '<br>';
//        echo "Longitude :" .$lng;
//    });

    Route::auth();
    Route::get('empty',function(){
        return view('errors.empty');
    });



    Route::get('activate',function(Illuminate\Http\Request $request) {
        $user = \Mjex\User::where('activation_code', $request->input('activation_code'))->first();
        if($user) {
            $user->active = 1;
            $user->save();
            $msg = 'Your account is activated. Please log in';
        }else{
            $msg = 'We can not found this activation code';
        }
        return redirect()->to('/login')->with('message', $msg);
    });

    Route::controller('contact', 'ContactController',[
        'getIndex' => 'contact'
    ]);

    Route::controller('find-growers', 'FindGrowerController',[
        'getIndex' => 'find-growers'
    ]);

    Route::get('/faq', function () {
        return view('faq');
    });

    Route::get('/', 'HomeController@index');
    Route::post('search', 'HomeController@search');

    Route::controller('review', 'ReviewController', [
        'postStore' => 'review.store',
    ]);

    Route::group(['middleware' => ['auth']], function () {
        Route::controller('cart','CartController',[
            'getIndex' => 'cart.index',
            'postAddToCart' => 'cart.add',
            'postClearCart' => 'cart.clear',
            'postSendOrder' => 'cart.send.order',
            'postUpdateQty' => 'cart.update.qty',
        ]);
        Route::controller('account','AccountController');
        Route::controller('chat','ChatController',[
            'postStore' => 'chat.store'
        ]);

        Route::controller('ad', 'AdController', [
            'getCreateFree' => 'ad.create.free',
            'getCreatePaid' => 'ad.create.paid',
            'postStoreFree' => 'ad.store.free',
            'postStorePaid' => 'ad.store.paid',
            'postRePost' => 'ad.repost',
            'postDestroy' => 'ad.destroy'
        ]);
    });
});