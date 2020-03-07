<?php

namespace App\Http\Controllers\Api\Category;

use App\Http\Controllers\Controller;
use App\Model\Category\Category;
use App\Repositories\Category\CategoryRepositoryInterface;
use Illuminate\Http\Request;

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
        $category = Category::where('name', $request['name'])->get();
    
        if (count($category)) {
            return [
                'message' => "This category [{$request['name']}] already exist."
            ];
        }

        $cateogry = Category::create($request->all());

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
    public function update(Request $request, int $id) : array
    {
        $category = Category::findOrFail($id);
        
        $category->update($request->all());
        
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
        
        if ($id) {
            return $category->find($id);
        }

        if ($request->has('start') && $request->has('end')) {
            return $category->skip($request['start'])->limit($request['end'])->get();
        }

        return Category::with('childCategories.listing','relevantCategories')->get();
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
}
