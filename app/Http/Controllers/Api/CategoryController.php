<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;

class CategoryController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        $category = Category::all()->toArray();
        return $this->responseSuccess(data: $category);
    }
}
