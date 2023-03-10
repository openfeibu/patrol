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

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {
    $api->get('/','App\Http\Controllers\Api\HomeController@index');
    $api->post('login', 'App\Http\Controllers\Api\Auth\LoginController@login');
    $api->get('/user_info','App\Http\Controllers\Api\UserController@getUser');
    $api->get('/order','App\Http\Controllers\Api\OrderController@getOrders');
    $api->get('/order/{id}','App\Http\Controllers\Api\OrderController@getOrder');
    $api->get('/order_count','App\Http\Controllers\Api\OrderController@getOrderCount');
    $api->post('/save_order','App\Http\Controllers\Api\OrderController@saveOrder');
    $api->post('/upload_order_image','App\Http\Controllers\Api\OrderController@uploadImage');
    $api->post('/change_password','App\Http\Controllers\Api\UserController@changePassword');
    $api->get('/work_card','App\Http\Controllers\Api\UserController@getWorkCard');

    $api->post('register', 'App\Http\Controllers\Api\Auth\RegisterController@register');
    $api->get('/page','App\Http\Controllers\Api\PageController@getPages');
    $api->get('/page/{id}','App\Http\Controllers\Api\PageController@getPage');
    $api->get('/page/slug/{slug}','App\Http\Controllers\Api\PageController@getPageSlug');
    $api->get('/page-category','App\Http\Controllers\Api\PageCategoryController@index');
    $api->get('/page-recruit','App\Http\Controllers\Api\PageController@getRecruits');
    $api->get('/page-contact','App\Http\Controllers\Api\PageController@getContacts');
    $api->get('/banners','App\Http\Controllers\Api\HomeController@getBanners');
    $api->get('/link','App\Http\Controllers\Api\LinkController@getLinks');
    $api->get('/nav','App\Http\Controllers\Api\NavController@getNavs');
    $api->post('test','App\Http\Controllers\Api\HomeController@test');
    $api->get('/link','App\Http\Controllers\Api\LinkController@getLinks');
    $api->get('/videoVid','App\Http\Controllers\Api\HomeController@getVideoVid');
});
