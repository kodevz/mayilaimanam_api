<?php

namespace App\Http\Controllers\Api\Listing;

use App\Http\Controllers\Controller;
use App\Model\Category\CategoryListingView;
use App\Model\Listing\Listing;
use App\Model\Listing\ListingCategory;
use Illuminate\Http\Request;

class ListingCategoryController extends Controller
{
    /**
     * @var Request
     */
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;      
    }

    /**
     * Fetch all categories
     *
     * @return array
     */
    public function index()
    {   
        $listing = ListingCategory::with('category', 'listing.openingTimes', 'listing.listingCategory')->get();

        return $listing;
    }
    
    /**
     * Show the single category by id
     *
     * @param int $id
     * @return void
     */
    public function show(int $id) : Listing
    {
        return ListingCategory::find($id);
    }

    /**
     * Create new category
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $cateogry = ListingCategory::create($request->all());

        return [
            'message' =>  'New category added successfully',
            'data' => [
                $cateogry
            ]
        ];
    }

    /**
     * Update category by id
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function update(Request $request, int $id) 
    {
        $category = ListingCategory::findOrFail($id);
        
        return $category;
    }

    /**
     * Delete the category by id
     *
     * @param Request $request
     * @param int $id
     * @return void
     */
    public function delete(Request $request, int $id)
    {
        $category = ListingCategory::findOrFail($id);

        $category->delete();

        return 204;
    }

    public function showCategoryListings(Request $request, string $query = null)
    {
        
        if (!$query || strlen($query) <= 2) {
            return [];
        }
        return CategoryListingView::with('openingTimes','categories.relevantCategories')
                                    ->where('category_name', 'LIKE', "%$query%")
                                    ->orWhere('title', 'LIKE', "%$query%")
                                    ->orWhere('address', 'LIKE', "%$query%")
                                    ->get();
    }
}
