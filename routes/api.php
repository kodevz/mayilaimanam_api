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

Route::middleware(['auth:api'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::namespace('Api\Auth')->group(function () {
    Route::post('register', 'RegisterController@register')->name('api.register');
    Route::post('register-from-user', 'RegisterController@registerFromUser')->name('api.registerFromUser');
    Route::post('verify-otp', 'RegisterController@verifyOtp')->name('api.verifyOtp');
    Route::post('resend-otp', 'RegisterController@resendOTP')->name('api.resendOTP');
    Route::post('email-verify', 'RegisterController@isEmailVerified')->name('api.isEmailVerified');
    Route::post('forget-password', 'RegisterController@resetPassword')->name('api.resetPassword');
});




Route::namespace('Plugin\Select2')->group(function () {
    Route::post('buildSelect2', 'Select2Controller@buildSelect2');
});

Route::middleware(['auth:api'])->group(function () {

    Route::namespace('Api\Auth')->group(function () {
        Route::post('whoami', 'RegisterController@whoAmI');
        Route::post('logoutApi', 'RegisterController@logoutApi');
    });
  

    Route::namespace('Api\Category')->group(function () {
        Route::get('category/all', 'CategoryController@index');
        Route::get('category/show/{id}', 'CategoryController@show');
        Route::get('category/search', 'CategoryController@searchCategory');
        Route::post('category/create', 'CategoryController@create');
        Route::post('category/{id}/update', 'CategoryController@update');

        Route::get('category/parent-categories', 'CategoryController@parentCategories');
        Route::get('category/parent/{id?}', 'CategoryController@showCategories');
        Route::post('category/parent/{id?}', 'CategoryController@showCategories');
        Route::get('category/child/{id}/list', 'CategoryController@showChildCategories');
    });


    Route::namespace('Api\Listing')->group(function () {
        Route::get('listing/all', 'ListingController@index');
        Route::post('listing/all', 'ListingController@index');
        Route::get('listing/show/{id}', 'ListingController@show');
        Route::get('listing/my/all', 'ListingController@myListings');
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
        Route::get('blood-donars/all', 'BloodDonarController@index');
        Route::post('blood-donars/all', 'BloodDonarController@index');
        Route::get('blood-donar/show/{id}', 'BloodDonarController@show');
        Route::post('blood-donar/create', 'BloodDonarController@create');
        Route::post('blood-donar/register', 'BloodDonarController@register');
        Route::post('blood-donar/{id}/update', 'BloodDonarController@update');
        Route::get('blood-groups/all', 'BloodDonarController@bloodGroups');
    });

    Route::namespace('Api\Ad')->group(function () {
        Route::get('ads/all', 'AdPostController@index');
        Route::post('ads/all', 'AdPostController@index');
        Route::get('ad/show/{id}', 'AdPostController@show');
        Route::post('ad/create', 'AdPostController@create');
        Route::post('ad/create-by-user', 'AdPostController@createByUser');
        Route::post('ad/{id}/update', 'AdPostController@update');
        Route::get('ad/{id}/delete', 'AdPostController@delete');
        Route::get('ads/my/all', 'AdPostController@myAds');
    });

    Route::namespace('Api\Users')->group(function () {
        Route::get('users/all', 'UsersController@index');
        Route::post('users/all', 'UsersController@index');
        Route::get('users/show/{id}', 'UsersController@show');
        Route::post('users/create', 'UsersController@create');
        Route::post('users/{id}/update', 'UsersController@update');
        Route::get('users/list/{id?}', 'UsersController@showUsers');
        Route::post('users/profile-info', 'UsersController@saveProfileInfo');
    });
});
