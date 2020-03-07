<?php

namespace App\Model\Category;

use App\Model\Listing\Listing;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
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
        return $this->belongsToMany(Listing::class, 'listing_categories', 'listing_id',  'category_id');
    }
}
