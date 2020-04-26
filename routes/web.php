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

use Illuminate\Support\Facades\Mail;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/mail', function () {
    $data = array('otp'=>"2346");
    Mail::send('otp', $data, function($message) {
        $message->to('karthi.php.developer@gmail.com', 'Otp')->subject('OTP Verification');
        $message->from('karthi.uk26@gmail.com','[QA] Test');
    });
});

Route::group(['middleware' => ['web']], function () {
    Route::get('category/top-menus', 'Pages\HomeController@topMenus');
    Route::get('page/home-sections', 'Pages\HomeController@homeSections');

    Route::post('listings', 'Pages\ListingsController@listings');
    Route::get('listing/detail', 'Pages\ListingsController@listingDetail');

    Route::get('category-menus', 'Pages\CategoryMenusController@categoryMenus');
    Route::get('sub-category-menus', 'Pages\CategoryMenusController@subCategoryMenus');

    Route::get('listing/{query}/search', 'Pages\ListingSearchController@searchListings');
});



Route::namespace('Api\Category')->group(function () {
    Route::get('category/all', 'CategoryController@index');
    Route::get('category/show/{id}', 'CategoryController@show');
    Route::post('category/create', 'CategoryController@create');
    Route::post('category/{id}/update', 'CategoryController@update');

    Route::get('category/parent/{id?}', 'CategoryController@showCategories');
    Route::get('category/child/{id}/list', 'CategoryController@showChildCategories');
});


Route::namespace('Api\Listing')->group(function () {
    Route::get('listing/all', 'ListingController@index');
    Route::get('listing/show/{id}', 'ListingController@show');
    Route::post('listing/create', 'ListingController@create');
    Route::post('listing/{id}/update', 'ListingController@update');

    

    Route::get('listing-category/all', 'ListingCategoryController@index');
    Route::get('listing-category/show/{id}', 'ListingCategoryController@show');
    Route::post('listing-category/create', 'ListingCategoryController@create');
    Route::post('listing-category/{id}/update', 'ListingCategoryController@update');

    Route::get('listing/category/{query}', 'ListingCategoryController@showCategoryListings')->name('listing_category_view');

    Route::get('opening-times/all', 'OpeningTimesController@index');
    Route::get('opening-times/show/{id}', 'OpeningTimesController@show');
    Route::get('opening-times/listing/{listingId}/show', 'OpeningTimesController@showListingOpeningTimes');
    Route::post('opening-times/create', 'OpeningTimesController@create');
    Route::post('opening-times/{listingId}/create', 'OpeningTimesController@createOpeningTimes');
    Route::post('opening-times/{id}/update', 'OpeningTimesController@update');
});

Route::namespace('Api\BloodDonar')->group(function () {
    Route::post('blood-donars/all', 'BloodDonarController@donars');
});