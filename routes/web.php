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

Route::get('/', function () {
    return view('welcome');
});
// Admin  routes  for user
Route::group([
    'namespace' => 'Admin',
    'prefix' => 'admin'
], function () {
    Auth::routes();
    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('password', 'AdminUserController@getPassword');
    Route::post('password', 'AdminUserController@postPassword');
    Route::get('/', 'ResourceController@home')->name('home');
    Route::get('/dashboard', 'ResourceController@dashboard')->name('dashboard');

    Route::resource('payment_company', 'PaymentCompanyResourceController');
    Route::post('/payment_company/destroyAll', 'PaymentCompanyResourceController@destroyAll');

    Route::resource('payment_user', 'PaymentUserResourceController');
    Route::post('/payment_user/destroyAll', 'PaymentUserResourceController@destroyAll')->name('payment_user.destroy_all');

    Route::resource('provider', 'ProviderResourceController');
    Route::post('/provider/destroyAll', 'ProviderResourceController@destroyAll')->name('provider.destroy_all');
    Route::get('provider_import', 'ProviderResourceController@import')->name('provider.import');
    Route::post('/provider_submit_import', 'ProviderResourceController@submitImport')->name('provider.submit_import');

    Route::resource('order', 'OrderResourceController');
    Route::post('/order/destroyAll', 'OrderResourceController@destroyAll')->name('order.destroy_all');

    Route::get('order_pending_provider','OrderResourceController@orderPendingProvider')->name('order.pending_provider');
    Route::get('order_pending_user','OrderResourceController@orderPendingUser')->name('order.pending_user');
    Route::get('order_working','OrderResourceController@orderWorking')->name('order.working');
    Route::get('order_finish','OrderResourceController@orderFinish')->name('order.finish');
    Route::get('order_return','OrderResourceController@orderReturn')->name('order.return');
    Route::get('order_pass','OrderResourceController@orderPass')->name('order.pass');
    Route::post('order_push_provider','OrderResourceController@pushProvider')->name('order.push_provider');
    Route::post('return_order','OrderResourceController@ReturnOrder')->name('order.return_order');
    Route::post('pass_order','OrderResourceController@PassOrder')->name('order.pass_order');
    Route::resource('provider_user', 'ProviderUserResourceController');
    Route::post('/provider_user/destroyAll', 'ProviderUserResourceController@destroyAll')->name('provider_user.destroy_all');
    Route::post('note_order','OrderResourceController@noteOrder')->name('order.note_order');
    Route::get('export_order','OrderResourceController@exportOrder')->name('order.export');

    Route::get('/setting/company', 'SettingResourceController@company')->name('setting.company.index');
    Route::post('/setting/updateCompany', 'SettingResourceController@updateCompany');
    Route::get('/setting/publicityVideo', 'SettingResourceController@publicityVideo')->name('setting.publicity_video.index');
    Route::post('/setting/updatePublicityVideo', 'SettingResourceController@updatePublicityVideo');
    Route::get('/setting/station', 'SettingResourceController@station')->name('setting.station.index');
    Route::post('/setting/updateStation', 'SettingResourceController@updateStation');


    Route::group(['prefix' => 'page','as' => 'page.'], function ($router) {
        Route::resource('page', 'PageResourceController');
        Route::resource('category', 'PageCategoryResourceController');
    });
    Route::group(['prefix' => 'menu'], function ($router) {
        Route::get('index', 'MenuResourceController@index');
    });

    Route::group(['prefix' => 'nav','as' => 'nav.'], function ($router) {
        Route::resource('nav', 'NavResourceController');
        Route::post('/nav/destroyAll', 'NavResourceController@destroyAll')->name('nav.destroy_all');
        Route::resource('category', 'NavCategoryResourceController');
        Route::post('/category/destroyAll', 'NavCategoryResourceController@destroyAll')->name('category.destroy_all');
    });

    Route::post('/upload/{config}/{path?}', 'UploadController@upload')->where('path', '(.*)');

    Route::resource('admin_user', 'AdminUserResourceController');
    Route::post('/admin_user/destroyAll', 'AdminUserResourceController@destroyAll')->name('admin_user.destroy_all');
    Route::resource('permission', 'PermissionResourceController');
    Route::post('/permission/destroyAll', 'PermissionResourceController@destroyAll')->name('permission.destroy_all');
    Route::resource('role', 'RoleResourceController');
    Route::post('/role/destroyAll', 'RoleResourceController@destroyAll')->name('role.destroy_all');

});

Route::group([
    'namespace' => 'Payment',
    'prefix' => 'payment',
    'as' => 'payment.',
], function () {
    Auth::routes();
    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('/', 'ResourceController@home')->name('home');
    Route::get('password', 'PaymentUserController@getPassword');
    Route::post('password', 'PaymentUserController@postPassword');
    Route::resource('provider', 'ProviderResourceController');
    Route::post('/provider/destroyAll', 'ProviderResourceController@destroyAll')->name('provider.destroy_all');
    Route::get('provider_import', 'ProviderResourceController@import')->name('provider.import');
    Route::post('/provider_submit_import', 'ProviderResourceController@submitImport')->name('provider.submit_import');
    //Route::post('/provider_submit_import_data', 'ProviderResourceController@submitImportData')->name('provider.submit_import_data');
    Route::resource('merchant', 'MerchantResourceController');
    Route::post('/merchant/destroyAll', 'MerchantResourceController@destroyAll')->name('merchant.destroy_all');
    Route::post('/merchant/create_order', 'MerchantResourceController@createOrder')->name('merchant.create_order');
    Route::post('/merchant/create_order_no_record','MerchantResourceController@createOrderNoRecord')->name('merchant.create_order_no_record');
    Route::get('merchant_import', 'MerchantResourceController@import')->name('merchant.import');
    Route::post('/merchant_submit_import', 'MerchantResourceController@submitImport')->name('merchant.submit_import');
    //Route::post('/merchant_submit_import_data', 'MerchantResourceController@submitImportData')->name('merchant.submit_import_data');
    Route::resource('order', 'OrderResourceController');
    Route::post('/order/destroyAll', 'OrderResourceController@destroyAll')->name('order.destroy_all');

    Route::get('order_pending_provider','OrderResourceController@orderPendingProvider')->name('order.pending_provider');
    Route::get('order_pending_user','OrderResourceController@orderPendingUser')->name('order.pending_user');
    Route::get('order_working','OrderResourceController@orderWorking')->name('order.working');
    Route::get('order_finish','OrderResourceController@orderFinish')->name('order.finish');
    Route::get('order_return','OrderResourceController@orderReturn')->name('order.return');
    Route::get('order_pass','OrderResourceController@orderPass')->name('order.pass');
    Route::post('order_push_provider','OrderResourceController@pushProvider')->name('order.push_provider');
    Route::post('return_order','OrderResourceController@ReturnOrder')->name('order.return_order');
    Route::post('pass_order','OrderResourceController@PassOrder')->name('order.pass_order');
    Route::resource('provider_user', 'ProviderUserResourceController');
    Route::post('/provider_user/destroyAll', 'ProviderUserResourceController@destroyAll')->name('provider_user.destroy_all');
    Route::post('note_order','OrderResourceController@NoteOrder')->name('order.note_order');
    Route::get('export_order','OrderResourceController@exportOrder')->name('order.export');

    Route::resource('payment_user', 'PaymentUserResourceController');
    Route::post('/payment_user/destroyAll', 'PaymentUserResourceController@destroyAll')->name('payment_user.destroy_all');
    Route::resource('permission', 'PermissionResourceController');
    Route::post('/permission/destroyAll', 'PermissionResourceController@destroyAll')->name('permission.destroy_all');
    Route::resource('role', 'RoleResourceController');
    Route::post('/role/destroyAll', 'RoleResourceController@destroyAll')->name('role.destroy_all');

    Route::post('/upload/{config}/{path?}', 'UploadController@upload')->where('path', '(.*)');
});
Route::group([
    'namespace' => 'Provider',
    'prefix' => 'provider',
    'as' => 'provider.',
], function () {
    Auth::routes();
    Route::get('logout', 'Auth\LoginController@logout');
    Route::get('/', 'ResourceController@home')->name('home');
    Route::get('password', 'ProviderUserController@getPassword');
    Route::post('password', 'ProviderUserController@postPassword');

    Route::resource('order', 'OrderResourceController');
    Route::post('/order/destroyAll', 'OrderResourceController@destroyAll')->name('order.destroy_all');

    Route::get('order_pending_user','OrderResourceController@orderPendingUser')->name('order.pending_user');
    Route::get('order_working','OrderResourceController@orderWorking')->name('order.working');
    Route::get('order_finish','OrderResourceController@orderFinish')->name('order.finish');
    Route::get('order_return','OrderResourceController@orderReturn')->name('order.return');
    Route::get('order_pass','OrderResourceController@orderPass')->name('order.pass');
    Route::post('order_push_user','OrderResourceController@pushUser')->name('order.push_user');
    Route::post('return_order','OrderResourceController@ReturnOrder')->name('order.return_order');
    Route::post('note_order','OrderResourceController@NoteOrder')->name('order.note_order');
    Route::get('export_order','OrderResourceController@exportOrder')->name('order.export');

    Route::resource('user', 'UserResourceController');
    Route::post('/user/destroyAll', 'UserResourceController@destroyAll')->name('user.destroy_all');
    Route::get('user_import', 'UserResourceController@import')->name('user.import');
    Route::post('/user_submit_import', 'UserResourceController@submitImport')->name('user.submit_import');

    Route::resource('provider_user', 'ProviderUserResourceController');
    Route::post('/provider_user/destroyAll', 'ProviderUserResourceController@destroyAll')->name('provider_user.destroy_all');
    Route::resource('permission', 'PermissionResourceController');
    Route::post('/permission/destroyAll', 'PermissionResourceController@destroyAll')->name('permission.destroy_all');
    Route::resource('role', 'RoleResourceController');
    Route::post('/role/destroyAll', 'RoleResourceController@destroyAll')->name('role.destroy_all');

    Route::post('/upload/{config}/{path?}', 'UploadController@upload')->where('path', '(.*)');
});

Route::group([
    'namespace' => 'Pc',
    'as' => 'pc.',
], function () {
    Auth::routes();
    Route::get('/user/login','Auth\LoginController@showLoginForm');
    Route::get('/','HomeController@home')->name('home');


    Route::get('email-verification/index','Auth\EmailVerificationController@getVerificationIndex')->name('email-verification.index');
    Route::get('email-verification/error','Auth\EmailVerificationController@getVerificationError')->name('email-verification.error');
    Route::get('email-verification/check/{token}', 'Auth\EmailVerificationController@getVerification')->name('email-verification.check');
    Route::get('email-verification-required', 'Auth\EmailVerificationController@required')->name('email-verification.required');


});
//Route::get('
///{slug}.html', 'PagePublicController@getPage');
/*
Route::group(
    [
        'prefix' => trans_setlocale() . '/admin/menu',
    ], function () {
    Route::post('menu/{id}/tree', 'MenuResourceController@tree');
    Route::get('menu/{id}/test', 'MenuResourceController@test');
    Route::get('menu/{id}/nested', 'MenuResourceController@nested');

    Route::resource('menu', 'MenuResourceController');
   // Route::resource('submenu', 'SubMenuResourceController');
});
*/