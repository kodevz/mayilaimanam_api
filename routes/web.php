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

use App\Mail\SendOTP;
use App\Model\Auth\OtpConfirmation;
use App\Model\Category\Category;
use App\Model\Listing\ListingView;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\View;

Route::get('/', function () {
    //View::addExtension('html', 'php');

    return View::make('welcome');
});

Route::get('/test', function() {
    return $listing = ListingView::with('listingCategory.category', 'openingTimes')->get();
});

Route::get('/create-admin', function () {
    \App\User::create([
        'username' => 'Admin',
        'email' => 'admin@mm.com',
        'password' => bcrypt('admin'),
    ]);
});

Route::get('/mail', function () {
    $data = array('otp'=>"2346");

    return Hash::make('admin');
    
    $optRow = OtpConfirmation::where('email', "karthi.php.developer@gmail.com")->first();

    $emailFor = $optRow->otp_for;
    dd($emailFor);
    if ($emailFor) {
        Mail::to($optRow->email)->send(new $emailFor($optRow));
    }
    
    // Mail::send('mail.register', $data, function($message) {
    //     $message->to('karthi.php.developer@gmail.com', 'Otp')->subject('Registration Confirmation');
    //     $message->from('karthi.uk26@gmail.com','Mayilai Manam');
    // });
});

Route::get('/email-template', function () {
   
    return View::make('mail.blooddonor', [
        'otp' => 2654,
        'otpText' => ''
    ]);
});

Route::group(['middleware' => ['web']], function () {
    Route::get('category/top-menus', 'Pages\HomeController@topMenus');
    Route::get('page/home-sections', 'Pages\HomeController@homeSections');

    Route::post('listings', 'Pages\ListingsController@listings');
    Route::get('listing/detail', 'Pages\ListingsController@listingDetail');

    Route::get('category-menus', 'Pages\CategoryMenusController@categoryMenus');
    Route::get('sub-category-menus', 'Pages\CategoryMenusController@subCategoryMenus');

    Route::get('listing/{query}/search', 'Pages\ListingSearchController@searchListings');

    Route::get('user/roles', 'Api\Users\UsersController@getRoles');
});



Route::namespace('Api\Category')->group(function () {
    Route::get('category/all', 'CategoryController@index');
    Route::get('category/show/{id}', 'CategoryController@show');
    Route::post('category/create', 'CategoryController@create');
    Route::post('category/{id}/update', 'CategoryController@update');

    Route::get('category/parent/{id?}', 'CategoryController@showCategories');
    Route::get('category/child/{id}/list', 'CategoryController@showChildCategories');

    Route::post('bus-timings', 'CategoryController@busTimings');
    Route::get('bus-departure-places', 'CategoryController@busDeparturePlaces');
    Route::get('bus-arrival-places', 'CategoryController@busArrivalPlaces');
    Route::post('train-timings', 'CategoryController@trainTimings');
    Route::get('train-departure-places', 'CategoryController@trainDeparturePlaces');
    Route::get('train-arrival-places', 'CategoryController@trainArrivalPlaces');
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
    Route::get('blood-donars/show-by-user/{id}', 'BloodDonarController@showByUserId');
    Route::get('blood-groups/all', 'BloodDonarController@bloodGroups');
    Route::get('blood-donars/area', 'BloodDonarController@donarsArea');
});

Route::namespace('Pages')->group(function () {
        Route::get('blood-donors/all', 'BloodDonarsApiController@index');
        Route::get('blood-donor/{id}/show', 'BloodDonarsApiController@show');
        Route::post('blood-donor/create', 'BloodDonarsApiController@store');
        Route::put('blood-donor/update', 'BloodDonarsApiController@update');
        Route::delete('blood-donor/{id}/delete', 'BloodDonarsApiController@delete');
});

Route::namespace('Pages')->group(function () {
    Route::get('address-books/all', 'AddressBookApiController@index');
    Route::get('address-book/{id}/show', 'AddressBookApiController@show');
    Route::post('address-book/create', 'AddressBookApiController@store');
    Route::post('address-book/update', 'AddressBookApiController@update');
    Route::delete('address-book/{id}/delete', 'AddressBookApiController@delete');

    Route::post('address-book/set-default-address', 'AddressBookApiController@updateSetDefaultAddress');
});

Route::namespace('Api\Common')->group(function () {
    Route::get('common/helpline-numbers', 'CommonController@helpLineNumbers');
    Route::get('common/play-store-link', 'CommonController@playStoreLink');
});




