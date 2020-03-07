<?php

namespace App\Model\Listing;

use App\Model\Category\Category;
use Illuminate\Database\Eloquent\Model;

class ListingCategory extends Model
{
    protected $table = 'listing_categories';

    protected $guarded = ['listing_id'];

    public $timestamps = false;

    public function listing()
    {
        return $this->belongsToMany(Listing::class, 'listing_id');
    }

    public function category() 
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

}
