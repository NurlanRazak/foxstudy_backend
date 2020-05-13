<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Http\Resources\CategoryResource;

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
            'message' => 'OK',
        ]);
    }
}
