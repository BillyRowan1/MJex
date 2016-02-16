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
    Route::auth();

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

    Route::group(['middleware' => ['auth']], function () {
        Route::controller('account','AccountController');
        Route::controller('ad', 'AdController', [
            'getCreateFree' => 'ad.create.free',
            'getCreatePaid' => 'ad.create.paid',
            'postStore' => 'ad.store',
            'postRePost' => 'ad.repost'
        ]);
    });
});