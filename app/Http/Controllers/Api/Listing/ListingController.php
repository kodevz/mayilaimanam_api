<?php

namespace App\Http\Controllers\Api\Listing;

use App\Http\Controllers\Controller;
use App\Model\Category\CategoryListingView;
use App\Model\Listing\Listing;
use App\Model\Listing\ListingCategory;
use App\Model\Listing\OpeningTimes;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Kodevz\MolyDatatable\Facades\MolyDataTable;

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
    public function index(Request $request)
    {   

        $listing = Listing::with('listingCategory.category', 'openingTimes');

        return MolyDataTable::create($listing)->opJson();
    }
    
    /**
     * Show the single category by id
     *
     * @param int $id
     * @return void
     */
    public function show(int $id) : Listing
    {   
        return Listing::with('listingCategory.category', 'openingTimes')->find($id);
    }

    /**
     * Create new category
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {   
        if (!$request->get('id')) {

             $validate = $request->validate([
                'title' => 'required|max:75',
                'short_description' => 'required|max:75',
                'slug' => '',
                'since' => 'required',
                'category_id' => 'required',
                'door_no' => 'required',
                'address_line_1' => 'required',
                'city' => 'required',
                'state' => 'required',
                'country' => 'required',
                'zipcode' => 'required',
                'description' => '',
                'mobile_no' => 'required|regex:/[0-9]{9}/',
                'telephone_no' => '',
                'phone_afterhours' => 'required',
                'business_mail' => '',
                'latitude' => '',
                'longitude' => '',
                'website' => '',
                'facebook' => '',
                'twitter' => '',
                'google_map_url' => '',
                'opening_times' => 'required | array',
                'opening_times.*.weekday' => 'required|nullable|regex:/^[a-zA-Z]+$/u',
            ]);

        }
       
        $relevantCategories = $request->get('relevant_categories') ?? [];
        $categoryId = $request->get('category_id');

        array_push($relevantCategories,  $categoryId);
   
        $listing = new Listing;
        if ($request->get('id')) {
            $listing = Listing::find($request->get('id'));
        }

        if ($request->file('banner_image')) {
            $listing->banner_image = $request->file('banner_image')->store('public/uploads/listing/images');
        }

        $listing->title = $request->get('title');
        $listing->short_description = $request->get('short_description');
        $listing->slug = $request->get('slug');
        $listing->categories = $request->get('category_id');
        $listing->user_id = Auth::user()->id;
        $listing->door_no = $request->get('door_no');
        $listing->since = new DateTime();
        $listing->address_line_1 = $request->get('address_line_1');
        $listing->city = $request->get('city');
        $listing->state = $request->get('state');
        $listing->country = $request->get('country');
        $listing->zipcode = $request->get('zipcode');
        $listing->description = $request->get('description');
        $listing->mobile_no = $request->get('mobile_no');
        $listing->telephone_no = $request->get('telephone_no');
        $listing->phone_afterhours = $request->get('phone_afterhours');
        $listing->business_mail = $request->get('business_mail');
        $listing->website = $request->get('website');
        $listing->latitude = $request->get('latitude');
        $listing->longitude = $request->get('longitude');
        $listing->facebook = $request->get('facebook');
        $listing->twitter = $request->get('twitter');
        $listing->google_map_url = $request->get('google_map_url');
        $listing->status = $request->get('status');
        $listing->save();

        if ($listing->id) {

            foreach ($request->get('opening_times') as $otime) {
                $openTime = new OpeningTimes;

                if ($otime['id']) {
                    $openTime =  OpeningTimes::find($otime['id']);
                }

                $openTime->listing_id = $listing->id;
                $openTime->weekday = $otime['weekday'];
                $openTime->start = $otime['start'];
                $openTime->end = $otime['end'];
                $openTime->holiday = $otime['holiday'];
                $openTime->save();
            }
        }

        $listing->categories()->sync($relevantCategories);
        return $this->show($listing->id);
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

    /**
     * Get all my listings
     *
     * @return array
     */
    public function myListings() : array
    {
         return Listing::with('listingCategory.category', 'openingTimes')-where('user_id', Auth::user()->id)->get();
    }


}
