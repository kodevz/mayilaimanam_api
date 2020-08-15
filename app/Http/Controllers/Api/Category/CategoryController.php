<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Model\Category\BusTimings;
use App\Model\Category\Category;
use App\Model\Category\TrainTimings;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Kodevz\MolyDatatable\Facades\MolyDataTable;

class CategoryController extends Controller
{
    /**
     * @var Request
     */
    protected $request;

    /**
     * @var CategoryRepositoryInterface
     */
    protected $category;

    public function __construct(Request $request, CategoryRepositoryInterface $category)
    {
        $this->request = $request;    
        $this->category = $category;    
    }

    /**
     * Fetch all categories
     *
     * @return array
     */
    public function index()
    {
        return $this->category->all();
    }
    
    /**
     * Show the single category by id
     *
     * @param int $id
     * @return void
     */
    public function show(int $id) : Category
    {
        return $this->category->find($id);
    }
    
    

    /**
     * Create new category
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required|unique:categories|max:75',
            'icon_url' => 'required',
            'image_url' => 'required',
        ]);
        
        $category = Category::where('name', $request['name'])->get();
    
        if (count($category)) {
            return [
                'violations' => $validate->errors
            ];
        }

        $category = new Category();
        
        $category->name = $request['name'];
        $category->slug = Str::slug($request['name'], '_');
        $category->icon_url = null;

        if ($request->file('icon_url')) {
            $category->icon_url = $request->file('icon_url')->store('uploads/category/icons', ['disk' => 'public']);
            
        }
        if ($request->file('image_url')) {
            $category->image_url = $request->file('image_url')->store('uploads/category/images', ['disk' => 'public']);
        }

        $category->save();

        if ($request->get('parent_id') == 'true') {
            $category->parent_id = $category->id;
            $category->save();
        }
        

        return [
            'message' =>  'New category added successfully',
            'data' => [
                $category
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
        $category = Category::findOrFail($id);
        
        $category->name = $request['name'];
         if ($request->file('icon_url')) {
            $category->icon_url = $request->file('icon_url')->store('uploads/category/icons', ['disk' => 'public']);
           
        }

        if ($request->file('image_url')) {
            $category->image_url = $request->file('image_url')->store('uploads/category/images', ['disk' => 'public']);
        }

    
        $category->parent_id = $request->get('parent_id') != 'null' ? $request->get('parent_id') : NULL;

        $category->save();
        
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
        $category = Category::findOrFail($id);

        $category->delete();

        return [
            'status' => TRUE,
            'msg' => 'Record Delete Successfully'
        ];
    }

    /**
     * Show Categories
     *
     * @return void
     */
    public function showCategories(Request $request, int $id = null)
    {   
        
        $category = Category::with('childCategories.listing','relevantCategories');

        $paginator = MolyDataTable::create($category)->opJson();
        
        return $paginator;

    }


    /**
     * Show child and relevant categories
     *
     * @param integer $id
     * @return void
     */
    public function showChildCategories(int $id)
    {
        return Category::with('childCategories','relevantCategories', 'listing')->find($id);
    }


    public function searchCategory(Request $request)
    {
        $search = $request->get('search');
        if (!$search) {
            return [];
        }
        return Category::where('name', 'Like', "%$search%")
                        ->take(50)->get();
    }

    public function parentCategories(Request $request)
    {
         //  return Category::where('parent_id', null)
        //                 ->get();
         return Category::get();
    }

    public function busTimings(Request $request)
    {
        $busTimings = BusTimings::select('*');


        $request['departureFrom'] && $busTimings->where('departure_from', $request['departureFrom']);
        $request['arrivalTo'] && $busTimings->where('arrival_to', $request['arrivalTo']);

        if ($request->get('departureTime') && $request->get('arrivalTime')) {
            $busTimings->where('departure_time', '>=' ,Carbon::parse($request['departureTime'])->format('H:i') . ':00');
            $request->has('arrivalTime') && $busTimings->where('arrival_time', '<=', Carbon::parse($request['arrivalTime'])->format('H:i') . ':00');
        }

        return $busTimings->get();
    }

    public function busDeparturePlaces(Request $request)
    {
        $departurePlaces = BusTimings::groupBy('departure_from')->get();

        return $departurePlaces;
    }

    public function busArrivalPlaces(Request $request)
    {
        $arrivalPlaces = BusTimings::groupBy('arrival_to')->get();

        return $arrivalPlaces;
    }


    public function trainTimings(Request $request)
    {
        $trainTimings = TrainTimings::select('*');


        $request['departureFrom'] && $trainTimings->where('departure_from', $request['departureFrom']);
        $request['arrivalTo'] && $trainTimings->where('arrival_to', $request['arrivalTo']);

        if ($request->get('departureTime') && $request->get('arrivalTime')) {
            $trainTimings->where('departure_time', '>=' ,Carbon::parse($request['departureTime'])->format('H:i') . ':00');
            $request->has('arrivalTime') && $trainTimings->where('arrival_time', '<=', Carbon::parse($request['arrivalTime'])->format('H:i') . ':00');
        }
        
        return $trainTimings->get();
    }

    public function trainDeparturePlaces(Request $request)
    {
        $departurePlaces = TrainTimings::groupBy('departure_from')->get();

        return $departurePlaces;
    }

    public function trainArrivalPlaces(Request $request)
    {
        $arrivalPlaces = TrainTimings::groupBy('arrival_to')->get();

        return $arrivalPlaces;
    }

}
