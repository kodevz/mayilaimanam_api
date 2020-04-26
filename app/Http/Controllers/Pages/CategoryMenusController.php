<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Model\Category\Category;
use Illuminate\Http\Request;

class CategoryMenusController extends Controller
{   
    
    public function __construct()
    {
        
    }

    public function categoryMenus(Request $request) 
    {
        $categoryMenus = Category::with('listing','childCategories');

        if ($request->get('showTopMenus') != 'false') {
            $categoryMenus->whereNULL('parent_id');
            $categoryMenus->whereNotNULL('order');
        } else {
            if ($request->get('parentId')) {
                $categoryMenus->where('parent_id', $request->get('parentId'));
            }
        }

        if ($request->get('search')) {
            $categoryMenus->where('name', 'LIKE', '%' . $request->get('search') . '%');
        }

        return $categoryMenus->skip($request->get('start'))->limit($request->get('end'))->get();              
    }

    /**
     * Get sub category menus
     *
     * @param Request $request
     * @return void
     */
    public function subCategoryMenus(Request $request)
    {
        return Category::with('listing','childCategories')
                        ->where('parent_id', $request->get('parent_id'))
                        ->get();
    }
}
