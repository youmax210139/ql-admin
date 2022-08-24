<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Http\Resources\Categories\Resource as CategoryResource;
use App\Http\Resources\Categories\Collection as CategoryCollection;

class CategoryController extends Controller
{
    /**
     * Show the profile view.
     *
     * @return json
     */
    public function index()
    {
        return new CategoryCollection(Category::paginate(10));
    }

    /**
     * Show the profile view.
     *
     * @return json
     */
    public function show(Category $user)
    {
        return new CategoryResource($user);
    }
}
