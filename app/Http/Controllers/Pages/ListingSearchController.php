<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Model\Category\CategoryListingView;
use Illuminate\Http\Request;

class ListingSearchController extends Controller
{
    
    public function __construct()
    {
        
    }

    public function searchListings(Request $request, string $query = null)
    {
        
        
        if (!$query || strlen($query) == 0) {
            return [
                'searchListings' => [],
                'searchCategories' => []
            ];
        }

        $limit = 20;
        $offset = $request->get('offset');

        if (strlen($query) < $request->get('lastquerylen')) {
            $limit =  $request->get('offset');
            $offset =  0;
        }

        $searchResults = collect(CategoryListingView::with('openingTimes','categories.relevantCategories')
                                    ->where('category_name', 'LIKE', "%$query%")
                                    ->orWhere('title', 'LIKE', "%$query%")
                                    ->orWhere('address', 'LIKE', "%$query%")
                                    ->skip($offset)
                                    ->limit($limit)
                                    ->get());
        
      
        $searchCategories = $searchResults->filter(function($result) {
            return !$result['listing_id'];
        })->values()->all();
      
        $searchListings = $searchResults->filter(function($result) {
            return $result['listing_id'];
        })->values()->all();

        return [
            'searchListings' => $searchListings,
            'searchCategories' => $searchCategories,
            'offset' => $request->query('offset')
        ];
    }
}
