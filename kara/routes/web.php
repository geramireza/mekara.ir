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

#admin routes
use Illuminate\Support\Facades\Response;

Route::group(['prefix' =>'admin' ,'namespace' => 'Admin', 'middleware' => 'admin','as' =>'admin.'],function (){
    Route::get("/",'AdminController@index')->name("dashbord");
    Route::get("confirmed",'AdminController@confirmed')->name('confirmed');
    Route::get("not-confirmed",'AdminController@notConfirmed')->name('not-confirmed');
    Route::get("create",'AdminController@create')->name("create");
    Route::post("store",'AdminController@store')->name("store");
    Route::get("edited",'AdminController@edited')->name('edited');
    Route::get("{token}/edit",'AdminController@edit')->name('posts.edit');
    Route::get("{token}/delete",'AdminController@delete')->name('posts.delete');
    Route::put("{token}",'AdminController@update')->name('posts.update');
    Route::get("posts-reports",'AdminController@postsReports')->name('posts-reports');
    Route::get("contacts-reports",'AdminController@contactsReports')->name('contacts-reports');
    Route::post("enable-post",'AdminController@enablePost')->name("enablePost");
    Route::post("delete-img-post",'AdminController@deleteImgPost')->name("deleteImgPost");
    Route::get("delete-report/{param}/{id}",'AdminController@deleteReport')->name("deleteReport");
    
    Route::get("blog","AdminController@createBlog")->name("blog");
    Route::post("blog-store","AdminController@storeBlog")->name("blog.store");

});

#user panel routes
Route::group(['namespace' => 'Web','middleware' => 'login'],function (){
    Route::get("my-kara/{param?}",'PostController@myKara')->name("myKara");
    Route::patch("republish/{token}",'PostController@rePublishPost')->name("rePublishPost");

});

// Download Route
Route::get('app',"DownloadController@download")->name("download");
Route::get('{data?}/app',"DownloadController@download");


#auth user routes
Route::group(['namespace' => 'Web'],function (){
    Route::get("login",'UserController@login')->name("login");
    Route::get("logout",'UserController@logout')->name("logout");
    Route::post("password",'UserController@sendPassword')->name("password");
    Route::post("confirm",'UserController@confirmPhone')->name("confirm");
});

#blog routes
Route::group(['namespace' => 'Web'],function (){
    Route::get("blog","BlogController@index")->name("blog");
    Route::get("blogs/{slug}","BlogController@index")->name("blogs.show");
});

#frontend website routes
Route::group(['namespace' =>'Web'],function (){
    Route::get('/','PostController@index')->name("home");
    Route::get('search/{param?}','PostController@getSearch')->name('search');
    Route::get('posts/search/{param?}','PostController@getSearchWithOtherParam')->name('search.with-param');
    Route::get('reSearch','PostController@reSearch')->name('reSearch');
    Route::get('more-posts/{param}','PostController@morePosts')->name("posts.more");
    Route::get('more-views','PostController@getMoreViews')->name("posts.more-views");
    Route::get('contact','ContactController@contact')->name('contact');
    Route::get('about','AboutController@about')->name('about');
    Route::get("manage/{param}/{token}",'PostController@managePosts')->name("manage");
    Route::get("{token}",'PostController@showWithToken')->name("show-with-token");
});

#other frontend website routes
Route::group(['prefix' => 'posts','namespace' =>'Web','as' => 'posts.'],function (){
    Route::get("create",'PostController@create')->name("create");
    Route::post("store",'PostController@store')->name("store");
    Route::post("delete/bookmark",'PostController@deleteBookmark')->name("delete-bookmark");
    Route::post("bookmark",'PostController@bookmark')->name("bookmark");
    Route::get("{slug}",'PostController@show')->name("show");
    Route::get("{post}/edit",'PostController@edit')->name("edit");
    Route::put("{token}",'PostController@update')->name("update");
    Route::post("delete/{post}",'PostController@delete')->name("delete");
});

# payment routes
Route::group(['prefix' => 'payment','namespace' => 'Payment'],function () {
    Route::post("request", 'WebPaymentController@paymentRequest')->name("payment-request");
    Route::get("verify/{postId}", 'WebPaymentController@paymentVerify')->name("payment-verify");
});


    
#posts report route
Route::post("posts-reports",'Web\ReportController@postsReports')->name("posts.reports");
Route::post("admin/seen-reports",'Web\ReportController@seenReports')->name("seen-reports");

#contact report route
Route::post("contacts-reports",'Web\ContactController@contactsReports')->name("contacts.reports");
Route::post("admin/seen-contacts",'Web\ContactController@seenContacts')->name("seen-contacts");


#test web apis
//Route::get("test/sms","TestController@sendLink");


