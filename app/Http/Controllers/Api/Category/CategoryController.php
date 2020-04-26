<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Model\Category\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;
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
            $category->icon_url = $request->file('icon_url')->store('public/uploads/category/icons');
        }
        if ($request->file('image_url')) {
            $category->image_url = $request->file('image_url')->store('public/uploads/category/images');
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
            $category->icon_url = $request->file('icon_url')->store('public/uploads/category/icons');
        }

        if ($request->file('image_url')) {
            $category->image_url = $request->file('image_url')->store('public/uploads/category/images');
        }

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

        return 204;
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
         return Category::where('parent_id', null)
                        ->get();
    }

}
