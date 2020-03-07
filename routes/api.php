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

Route::namespace('Api\Auth')->group(function () {
    Route::post('register', 'RegisterController@register')->name('api.register');
});




Route::middleware(['auth:api'])->group(function () {

    Route::post('sessionUser', 'UserController@sessionUser');

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

        Route::get('listing/category/{id}', 'ListingCategoryController@showCategoryListings');

        Route::get('opening-times/all', 'OpeningTimesController@index');
        Route::get('opening-times/show/{id}', 'OpeningTimesController@show');
        Route::get('opening-times/listing/{listingId}/show', 'OpeningTimesController@showListingOpeningTimes');
        Route::post('opening-times/create', 'OpeningTimesController@create');
        Route::post('opening-times/{listingId}/create', 'OpeningTimesController@createOpeningTimes');
        Route::post('opening-times/{id}/update', 'OpeningTimesController@update');
    });

});

