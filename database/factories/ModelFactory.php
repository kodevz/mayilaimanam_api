<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Category\Category;
use App\Model\Listing\Listing;
use App\Model\Listing\Ratings;
use App\Model\Listing\Reviews;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

$factory->define(User::class, function (Faker $faker) {
    return [
        'first_name' => $faker->firstName,
        'last_name' => $faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'password' => Hash::make('1234')
    ];
});


$factory->define(Listing::class, function (Faker $faker) {
    return [
        'user_id' => rand(2,1000),
        'title' => $faker->sentence(1, false),
        'slug' => $faker->slug,
        'description' => $faker->text,
        'phone_afterhours' => rand(1,23),
        'logo' => $faker->imageUrl(640, 480),
        'phone' => $faker->unique()->phoneNumber,
        'website' => "www.". $faker->domainName,
        'email' => $faker->unique()->companyEmail,
        'service_area' => $faker->text,
        'address' => $faker->address,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude
    ];
});


$factory->define(Category::class, function (Faker $faker) {
    return [
        'name' => $faker->unique()->sentence(2, false),
        'slug' => $faker->slug,
        'parent_id' => rand(100, 1720)
    ];
});

$factory->define(Ratings::class, function (Faker $faker) {
    static $number = 1;
    return [
        'rating_value' => $faker->unique()->sentence(2, false),
        'listing_id' => rand(2,1000),
        'rating_by' => $number++,
        'rating_value' => mt_rand(0,50) / 10
    ];
});

$factory->define(Reviews::class, function (Faker $faker) {
    static $number = 1;
    return [
        'comments' => $faker->realText($maxNbChars = rand(50,200), $indexSize = 2),
        'listing_id' => rand(2,1000),
        'review_by' => rand(2,1000),
    ];
});
