<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v1'], function () {
    Route::post('login', 'APIController@login');
    Route::post('registerUser', 'APIController@registerUser');

    Route::get('getBanners', 'APIController@getBanners');
    Route::get('getHome','APIController@home');
    Route::get('getProducts/{category_id?}/{keyword?}', 'APIController@getProducts');
    Route::post('sendContact','APIController@sendContact');
    Route::post('getSellerData','APIController@getSellerData');
    Route::get('profile/{id}','APIController@profile');
    Route::post('updateProfile','APIController@updateProfile');

    Route::group(['middleware'=> 'jwt.auth'], function() {
        Route::post('logout', 'APIController@logout');
        Route::post('registerOrder', 'APIController@registerOrder');
        Route::post('saveFavoriteProducts', 'APIController@saveFavoriteProducts');
    });
});
