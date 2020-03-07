<?php

namespace App\Http\Controllers\Api\Listing;

use App\Http\Controllers\Controller;
use App\Model\Listing\Listing;
use App\Model\Listing\ListingCategory;
use Illuminate\Http\Request;

class ListingController extends Controller
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
        $listing = Listing::with('listingCategory.category', 'openingTimes')->get();

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
        return Listing::find($id);
    }

    /**
     * Create new category
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $cateogry = Listing::create($request->all());

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
        $category = Listing::findOrFail($id);
        
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
        $category = Listing::findOrFail($id);

        $category->delete();

        return 204;
    }
}
