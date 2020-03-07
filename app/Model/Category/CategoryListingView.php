<?php

namespace App\Model\Category;

use App\Model\Listing\OpeningTimes;
use Illuminate\Database\Eloquent\Model;

class CategoryListingView extends Model
{

    protected $table = 'category_listing_view';
    
    protected $primaryKey = 'id';

    public function openingTimes()
    {
        return $this->hasMany(OpeningTimes::class, 'listing_id', 'listing_id');
    }

    public function categories()
    {
        return $this->hasMany(Category::class, 'id');
    }

    public function relevantCategories()
    {
        return $this->hasMany(RelevantCategory::class, 'id');
    }
}
