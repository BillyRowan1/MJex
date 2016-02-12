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

    Route::get('/', function () {
        return view('index');
    });

    Route::get('/contact', function () {
        return view('contact');
    });

    Route::get('/find-growers', function () {
        return view('find_growers');
    });

    Route::get('/faq', function () {
        return view('faq');
    });

    Route::get('/home', 'HomeController@index');

    Route::group(['middleware' => ['auth']], function () {
        Route::controller('account','AccountController');
        Route::controller('ad', 'AdController', [
            'getCreate' => 'ad.create',
            'postStore' => 'ad.store',
            'postRePost' => 'ad.repost'
        ]);
    });
});