<?php

namespace App\Model\Category;

use App\Model\Listing\Listing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\App;

class Category extends Model
{

    use SoftDeletes;
    
    protected $table = 'categories';

    protected $fillable = [
        'name', 'slug'
    ];

    public function childCategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function relevantCategories()
    {
        return $this->hasMany(RelevantCategory::class, 'id');
    }

    public function listing()
    {
        return $this->belongsToMany(Listing::class, 'listing_categories', 'category_id',  'listing_id');
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
