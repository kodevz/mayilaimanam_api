<?php

namespace App\Http\Controllers\Pages;

use App\Http\Controllers\Controller;
use App\Model\Ad\AdPost;
use App\Model\Category\CategoryListingView;
use App\Model\Category\TopMenusView;
use Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        
    }

    public function homeSections() 
    {
        return [
            'data' => [
                'menuSection' => $this->topMenus(),
                'adSections' => $this->addSections(),
                'nearBySection' => $this->exploreNearBy(),
                'recentListingSection' => $this->recentListings(),
                'recommendedSection' => $this->recommendedListings()
            ]
        ];
    }

    public function topMenus()
    {
        return TopMenusView::with('childMenus')->limit(15)->get();
    }

    public function addSections()
    {
        return AdPost::orderBy('id', 'DESC')->limit(10)->get();
    }

    public function exploreNearBy()
    {
        return [];
    }

    public function recentListings()
    {
        return CategoryListingView::paginate(15)->values();
    }

    public function recommendedListings()
    {
        return [];
    }
}
