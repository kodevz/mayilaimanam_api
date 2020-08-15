<?php

namespace App\Http\Controllers\Api\Common;

use App\Http\Controllers\Controller;
use App\Model\Category\BusTimings;
use App\Model\Category\Category;
use App\Model\Category\TrainTimings;
use App\Model\Common\HelpLine;
use App\Model\Listing\Ratings;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Kodevz\MolyDatatable\Facades\MolyDataTable;
use PHPUnit\TextUI\Help;

class CommonController extends Controller
{
    /**
     * @var Request
     */
    protected $request;


    public function __construct(Request $request)
    {
        $this->request = $request;      
    }

   
    public function helpLineNumbers(Request $request)
    {
    
        $helpLine = HelpLine::select('*');

        if ($request->get('search')) {
            $helpLine->where('name', 'LIKE', "%{$request['search']}%");
        }

        return $helpLine->skip($request->get('start'))->limit($request->get('end'))->get();                           
    
    }

    public function playStoreLink()
    {
        return [
            'url' => 'https://play.google.com/store/apps/details?id=com.shaorganic.mayilaimanam&hl=en_IN'
        ];
    }

    /**
     * Get Rating For Listing
     *
     * @param Request $request
     * @param integer $listingId
     * @return void
     */
    public function getRatingForListing(Request $request)
    {
        $authUser = $request->user();
        
        return Ratings::where([
            'listing_id' => $request['listingId'],
            'rating_by' => $authUser->id,
        ])->firstOrFail();
    }

    /**
     * Give rating feed back
     *
     * @param Request $request
     * @return void
     */
    public function giveListingRating(Request $request)
    {
        $authUser = $request->user();
        $rating = Ratings::updateOrCreate(
            [
                'listing_id' => $request['listingId'],
                'rating_by' => $authUser->id,
            ],
            [
                'rating_value' => $request['ratingValue'],
                'listing_id' => $request['listingId'],
                'rating_by' => $authUser->id
            ]
        );
        return $rating;
    }

}
