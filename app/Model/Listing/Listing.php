<?php

namespace App\Model\Listing;

use App\Model\Category\Category;
use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $table = 'listings';

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

}
