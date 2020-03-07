<?php 
namespace App\Repositories\Category;

use App\Model\Category\Category;

class CategoryRepository implements CategoryRepositoryInterface{


    public function all()
    {
        return Category::all();
    }

    public function find($id)
    {
        return Category::find($id);
    }

    public function store()
    {

    }

    public function delete($id)
    {

    }
}