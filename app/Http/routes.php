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
    Route::get('test', function(){
        return config('mail.contact');
    });
    Route::controller('domain-email', 'DomainEmailController');

    Route::group(['prefix' => 'mjexadmin'], function () {
        Route::controller('auth', 'Admin\SessionController');

        Route::group(['middleware'=>'admin'], function() {
            Route::controller('/', 'Admin\DashboardController');
        });
    });

    Route::controller('dispensaries', 'DispensaryController');
    Route::controller('products', 'ProductController');

    Route::get('email-template/account-activation', function(\Illuminate\Http\Request $request){
        $user = Mjex\User::find($request->input('id'));
        if(!$user) abort(404);

        return view('emails.activate', compact('user'));
    });
    Route::get('email-template/grower-request', function(\Illuminate\Http\Request $request){
        $seeker = Mjex\User::find($request->input('id'));
        $grower = Mjex\User::find($request->input('grower_id'));

        if(!$seeker) abort(404);

        return view('emails.grower_request', compact('seeker','grower'));
    });
    // Password reset link request routes...
    Route::get('password/email', 'Auth\PasswordController@getEmail');
    Route::post('password/email', 'Auth\PasswordController@postEmail');

    // Password reset routes...
    Route::get('password/reset/{token}', 'Auth\PasswordController@getReset');
    Route::post('password/reset', 'Auth\PasswordController@postReset');

    Route::post('stripe/webhook', '\Laravel\Cashier\WebhookController@handleWebhook');

    Route::auth();
    Route::get('empty',function(){
        return view('errors.empty');
    });

    Route::get('confirm-order',function(Illuminate\Http\Request $request) {
        $msg = "Sorry, seller refuse your order";
        $buyer = \Mjex\User::find($request->input('b'));

        if(!is_null($buyer)) {
            if($request->input('a') ==  'yes') {
                $msg = "Thanks, your order is being processed";
            }
        }

        \Mail::send('emails.msg_to_grower',['msg'=>$msg], function ($m) use ($buyer){
            $m->to($buyer->email)->subject('Mjex order confirmation');
        });

        return "Your confirmation has been sent to buyer";
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

    Route::controller('ad-network', 'AdNetworkController',[
        'getIndex' => 'ad-network'
    ]);

    Route::get('/faq', function () {
        return view('faq');
    });

    Route::get('/', 'HomeController@index');
    Route::get('search', 'HomeController@search');

    Route::controller('review', 'ReviewController', [
        'postStore' => 'review.store',
        'getWrite' => 'review.write',
    ]);

    Route::controller('sellermap', 'SellerMapController', [
    ]);

    Route::controller('cart','CartController',[
        'getIndex' => 'cart.index',
        'postAddToCart' => 'cart.add',
        'postClearCart' => 'cart.clear',
        'postDelete' => 'cart.delete',
        'postSendOrder' => 'cart.send.order',
        'postUpdateQty' => 'cart.update.qty',
        'postSelectAsMyGrower' => 'cart.select.as.grower',
    ]);

    Route::group(['middleware' => ['auth']], function () {

        Route::controller('account','AccountController',[
            'postRequestReview' => 'account.request.review'
        ]);
        Route::controller('chat','ChatController',[
            'postStore' => 'chat.store'
        ]);

        Route::controller('ad', 'AdController', [
            'getCreateFree' => 'ad.create.free',
            'getCreatePaid' => 'ad.create.paid',
            'getCreateBanner' => 'ad.create.banner',
            'getEdit' => 'ad.edit',
            'postUpdate' => 'ad.update',
            'postStoreFree' => 'ad.store.free',
            'postStorePaid' => 'ad.store.paid',
            'postRePost' => 'ad.repost',
            'postDestroy' => 'ad.destroy'
        ]);
    });
});