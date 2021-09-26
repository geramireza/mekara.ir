
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


# mobile routes
Route::group(['prefix' => 'posts','namespace' => 'Mobile'],function (){

    Route::post('/','PostController@index');
    Route::post('show','PostController@show');
    Route::post('store','PostController@store');
    Route::post('delete','PostController@delete');
    Route::post('rePublish','PostController@rePublish');
    Route::post('getPostForEdit','PostController@getPostForEdit');
    Route::post('update','PostController@update');
    Route::post('bookmark','PostController@bookmark');
    Route::post('myPost','PostController@myPost');
    Route::post('myView','PostController@myView');
    Route::post('myBookmark','PostController@myBookmark');
    Route::post('search','PostController@search');
    Route::post('reports','ReportController@postsReports');

});

Route::group(['prefix' => 'users','namespace' => 'Mobile'],function (){
    Route::post('store','UserController@store');
    Route::post("password",'UserController@sendPassword');
});

Route::post('contacts-reports','Mobile\ContactController@contactsReports');
Route::post('cities','Mobile\PostController@getCities');
Route::post('postAndPrices','Mobile\PostController@getPostAndPrices');
Route::get('appVersion','DownloadController@getAppVersion');

Route::get("payment/request/{data}", 'Payment\AppPaymentController@paymentRequest');
//Route::get("verify/{postId}/", 'Payment\TestPayController@paymentVerify');
Route::get("payment/verify/{postId}", 'Payment\AppPaymentController@paymentVerify');



// test apis
//Route::post("test/sms","TestController@sendLink");







