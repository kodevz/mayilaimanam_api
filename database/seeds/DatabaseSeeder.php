<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);

        // factory(App\User::class, 1001)->create()->each(function ($user) {
        //     $user->roles()->attach([4]);
        // });

        // factory(App\Model\Listing\Listing::class, 1000)->create()->each(function ($listing) {
        //     for ($i=1; $i < rand(1, 10); $i++) { 
        //         $listing->categories()->attach([rand(1, 1719)]);
        //     } 
        // });

        //factory(App\Model\Category\Category::class, 1720)->create();

        //factory(App\Model\Listing\Ratings::class, 1000)->create();
        factory(App\Model\Listing\Reviews::class, 7500)->create();
    }
}
