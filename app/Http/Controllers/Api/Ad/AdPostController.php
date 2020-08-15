<?php

namespace App\Http\Controllers\Api\Ad;

use App\Http\Controllers\Controller;
use App\Model\Ad\AdPost;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Kodevz\MolyDatatable\Facades\MolyDataTable;

class AdPostController extends Controller
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
        $ads = new AdPost();
                             
        $paginator = MolyDataTable::create($ads)->opJson();

        return $paginator;
    }


    
    /**
     * Show the single category by id
     *
     * @param int $id
     * @return void
     */
    public function show(int $id) : AdPost
    {
        return AdPost::withTrashed()->find($id);
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
                'ad_title' => 'required|max:75',
                'ad_subtitle' => 'required|max:75',
                'ad_content' => 'required|max:1000',
                'ad_by' => 'required',
                'ad_status' => 'required',
                'ad_image' => 'required|max:500|mimes:jpeg,png',
            ]);
        }

        $ad = new AdPost;
        if ($request->get('id') && $request->get('id') != 'null') {
            $ad = AdPost::find($request->get('id'));
        }
        
        $ad->ad_post_date = Carbon::parse($request->get('ad_post_date'))->format('Y-m-d');
        $ad->ad_title = $request->get('ad_title');
        $ad->ad_subtitle = $request->get('ad_subtitle');
        $ad->ad_content = $request->get('ad_content');
        $ad->ad_visible_days = $request->get('ad_visible_days');
        $ad->ad_status = $request->get('ad_status');
     
        if ($request->file('ad_image')) {
            $ad->ad_image = $request->file('ad_image')->store('uploads/ad/images', ['disk' => 'public']);
        }

        $ad->save();

        return $ad;
    }


    /**
     * Create new category
     *
     * @param Request $request
     * @return void
     */
    public function createByUser(Request $request)
    {   
        
        if (!$request->get('id')) {
             $validate = $request->validate([
                'ad_title' => 'required|max:75',
                'ad_subtitle' => 'required|max:75',
                'ad_content' => 'required|max:1000',
                'ad_image' => 'required|max:500000|mimes:jpeg,png',
            ]);
        }

        $ad = new AdPost;
        if ($request->get('id')) {
            $ad = AdPost::find($request->get('id'));
        }

        if (!$request->get('id')) {
            $ad->ad_post_date = date('y-m-d');
        }

       
        $ad->ad_title = $request->get('ad_title');
        $ad->ad_subtitle = $request->get('ad_subtitle');
        $ad->ad_content = $request->get('ad_content');
        $ad->ad_by = Auth::user()->id;
     
        if ($request->file('ad_image')) {
            $ad->ad_image = $request->file('ad_image')->store('public/uploads/ad/images');
        }

        $ad->save();

        return $ad;
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
       return AdPost::findOrFail($id);
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
        $ad = AdPost::findOrFail($id);

        $ad->delete();

        return [
            'status' => TRUE,
            'msg' => 'Record Delete Successfully'
        ];
    }

    /**
     * Show my ads
     *
     * @return object
     */
    public function myAds() : object
    {
        return AdPost::where('ad_by', Auth::user()->id)->get();
    }
}
