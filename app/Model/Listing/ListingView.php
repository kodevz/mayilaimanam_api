<?php

namespace App\Model\Listing;

use App\Model\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;
class ListingView extends Model
{
    protected $table = 'listings_view';

    protected $guarded  = ['id', 'created_at', 'updated_at'];

    public function listingCategory()
    {
        return $this->hasMany(ListingCategory::class, 'listing_id');
    }

    public function openingTimes()
    {
        return $this->hasMany(OpeningTimes::class, 'listing_id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'listing_categories', 'listing_id', 'category_id')->withPivot('listing_id', 'category_id');
    }

    public function rating()
    {
        return $this->hasOne(Ratings::class, 'listing_id');
    }

    public function getBannerImageAttribute($value) 
    {
        $appUrl = App::make('url')->to('/');
        return str_replace("public/", " $appUrl/storage/app/public/", $value);
    }
}
