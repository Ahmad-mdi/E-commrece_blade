<?php

namespace App\Http\Controllers\ClientController;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Category $category)
    {
        return view('client.categories.index',[
           'category' => $category,
        ]);
    }

    public function getChildren(Category $childCategory)
    {
        return view('client.categories.childCategory',[
            'childCategory' => $childCategory,
        ]);
    }
}
