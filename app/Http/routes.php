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
    Route::get('/', function () {
        return view('home');
    });
    Route::get('/contact', function () {
        return view('contact');
    });
    Route::get('/signup', function (\Illuminate\Http\Request $request) {
        $package = $request->input('package');
        return view('signup', compact('package'));
    });
    Route::get('/find-growers', function () {
        return view('find_growers');
    });

    Route::get('/post-ad', function () {
        return view('post_ad');
    });

    Route::get('/faq', function () {
        return view('faq');
    });

});