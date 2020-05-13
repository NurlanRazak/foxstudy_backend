<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubcategoryResource;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $data = [];

        $categories = Category::active()->get();

        if(!$categories)
        {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        foreach($categories as $category) {
            $data[] = new CategoryResource($category);
        }

        return response()->json([
            'data' => $data,
            'message' => 'OK, keep going, u doing well.',
        ]);
    }

    public function subcategories(Request $request)
    {
        $data = [];

        $subcategories = Subcategory::active()->get();

        if(!$subcategories) {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        foreach ($subcategories as $subcategory) {
            $data[] = new SubcategoryResource($subcategory);
        }

        return response()->json([
            'data' => $data,
            'message' => 'Yo, u got it.',
        ]);
    }
}
