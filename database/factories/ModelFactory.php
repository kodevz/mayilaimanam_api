<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Category\Category;
use App\Model\Listing\Listing;
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
        'name' => $faker->sentence(2, false),
        'slug' => $faker->slug,
        'parent_id' => rand(100, 1720)
    ];
});
