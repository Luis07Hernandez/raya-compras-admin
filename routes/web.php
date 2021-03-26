<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/','HomeController@index');

Route::resource('/banners', 'BannerController');
Route::post('/changestatus', 'BannerController@changestatus');
Route::resource('/products', 'ProductsController');
Route::post('/changestatus2', 'ProductsController@changestatus2');
Route::post('/changestatusOust', 'ProductsController@changestatus3');
Route::post('/changestatusCustomer', 'CustomerController@changestatus4');
Route::resource('/customers', 'CustomerController');
Route::resource('/routes', 'RouteController');
Route::get('/ticket/{id}/{category_id?}', 'OrderController@tikett');
Route::resource('/orders', 'OrderController');
Route::post('/filtro', 'OrderController@filtro');
Route::post('/updatestatusOrder', 'OrderController@updateOrder');
Route::resource('/reports', 'ReportController');
Route::post('/filtroCategorias', 'ReportController@filtroCategorias');
Route::resource('/sellerReport', 'SellerReportController');
Route::post('/filtroSellerCategorias', 'SellerReportController@filtroSellerCategorias');
Route::resource('/providers', 'ProviderController');
Route::get('/getNotification','NotificationController@getNotification');
Route::get('/getCountNotification','NotificationController@getCountNotification');
Route::get('/updateNotification','NotificationController@updateNotification');
Route::resource('/sellers', 'SellerController');
Route::resource('/categories', 'CategorIesController');
Route::resource('/comment', 'CommentController');
//Route::resource('/tikets/{id}', 'TiketController');
////Route::resource('/tikets', 'TiketController');
//Route::post('/tiketfilter', 'TiketController@tiketfilter');
//Route::post('/tabletiket', 'TiketController@tabletiket');