<?php

namespace App\Model\Category;

use App\Model\Category\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\App;

class TopMenusView extends Model
{
    protected $table = 'top_menus_view';
    
    protected $primaryKey = 'id';

    public function childMenus() {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function getIconUrlAttribute($value) 
    {
        $appUrl = App::make('url')->to('/');
        return str_replace("public/", "$appUrl/public/storage/", $value);
    }

}
