<?php

namespace App\Model\Category;

use App\Model\Listing\OpeningTimes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

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

    public function getIconUrlAttribute($value) 
    {
       
        if (strpos($value, 'public') === FALSE) {
            $value = 'public/'. $value;
        }
        $appUrl = App::make('url')->to('/');
        return str_replace("public/", " $appUrl/public/storage/", $value);
    }

    public function getImageUrlAttribute($value) 
    {
        
        if (strpos($value, 'public') === FALSE) {
            $value = 'public/'. $value;
        }
        $appUrl = App::make('url')->to('/');
        return str_replace("public/", " $appUrl/public/storage/", $value);
    }
}
