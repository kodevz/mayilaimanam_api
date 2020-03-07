<?php

namespace App\Http\Controllers\Api\Listing;

use App\Http\Controllers\Controller;
use App\Model\Listing\Listing;
use App\Model\Listing\OpeningTimes;
use Illuminate\Http\Request;

class OpeningTimesController extends Controller
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
        return OpeningTimes::with('category', 'listing.openingTimes', 'listing.listingCategory')->get();
    }
    
    /**
     * Show the single category by id
     *
     * @param int $id
     * @return void
     */
    public function show(int $id) : OpeningTimes
    {
        return OpeningTimes::find($id);
    }

    public function showListingOpeningTimes(int $listingId)
    {
        return OpeningTimes::with('listing')
                            ->where('listing_id', $listingId)->get();
    }

    /**
     * Create new Opening times for business listing
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        try {
            $openTime = OpeningTimes::create($request->all());
            return [
                'message' =>  'Opening times added sucessfully',
                'data' => [
                    $openTime
                ]
            ];
        } catch (\Throwable $th) {
            
            return [
                "message" => $th
            ];
        }
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
       $openingTimes = OpeningTimes::findOrFail($id);

       $openingTimes->update($request->all());

       return $openingTimes;
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
        $openingTime = OpeningTimes::findOrFail($id);

        $openingTime->delete();

        return 204;
    }
}
