<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Model\Category\CategoryListingView;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ListingsController extends Controller
{
    public function __construct()
    {
        
    }


    public function listings(Request $request) 
    {   

        $lat = 11.127122499999999; 
        $lon = 78.6568942; 
        $dist = $request['radius'] == '50+' ? '75' : $request['radius'] * 0.621371; 

        $categoryIds =  $request->get('category_id');

        if (!count($categoryIds)) {
            $categoryIds[] = $request->get('parent_id');
        }
        
        $distanceSQL = "3956 * 2 * ASIN(SQRT(POWER(SIN(($lat-ABS(latitude)) * PI()/180/2),2) + COS($lat * PI()/180) * COS(ABS(latitude) * PI()/180) * POWER(SIN(($lon-longitude) * PI()/180/2),2))) AS distance";
        $categoryListingView = CategoryListingView::select(
                                        DB::raw("*,3956 * 2 * ASIN(SQRT(POWER(SIN(($lat-ABS(latitude)) * PI()/180/2),2) + COS($lat * PI()/180) * COS(ABS(latitude) * PI()/180) * POWER(SIN(($lon-longitude) * PI()/180/2),2))) AS distance")
                                );
                                
        
        if (count($categoryIds)) {
            $categoryListingView->whereIn('id', $categoryIds);
        }   

        if ($request->has('rating_value')) {
            $categoryListingView->where('rating_value', '>=' , $request['rating_value']);
        }

        if ($request->get('nearByMe')) {
            $categoryListingView->whereRaw("
                    longitude BETWEEN ($lon-$dist / ABS(COS(RADIANS($lat))*69)) AND ($lon+$dist / ABS(COS(RADIANS($lat)) * 69))
                    AND latitude BETWEEN ($lat-($dist/69)) AND ($lat+($dist/69))
            ");
            $categoryListingView->groupBy('listing_id');
            $categoryListingView->having("distance","<", $dist);
            $categoryListingView->orderBy('distance', 'ASC');
        } 

        $categoryListingView->orderBy('rating_value', 'DESC');

       

        return $categoryListingView->skip($request->get('start'))->limit($request->get('end'))->get();
    }

    public function listingDetail(Request $request)
    {
        $categoryId = $request->get('categoryId');
        $listingId = $request->get('listingId');
        return CategoryListingView::with('openingTimes','categories.relevantCategories')
                                    ->where('listing_id', $listingId)
                                    ->where('id', $categoryId)
                                    ->first();
    }
}
