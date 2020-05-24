<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Course;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\SubcategoryResource;
use App\Http\Resources\CourseResource;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $data = [];

        $categories = Category::active()->orderBy('lft')->get();

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

        $subcategories = Subcategory::active()->orderBy('lft')->get();

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

    public function courses(Request $request)
    {
        $data = [];

        $courses = Course::get();


        if(!$courses) {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        foreach ($courses as $course) {
            $data[] = new CourseResource($course);
        }
        return response()->json([
            'data' => $data,
            'message' => 'good',
        ]);
    }

    public function course(Request $request, string $course_id)
    {
        $course = Course::where('id', $course_id)->first();
        return new CourseResource($course);
    }

    public function search(Request $request)
    {
        if (!$request->q) {
            abort(400, 'q is required');
        }
        $query = Course::where('name', 'LIKE', '%'.$request->q.'%')
                        ->orWhere('short_description', 'LIKE', '%'.$request->q.'%')->get();

        return response()->json($request->per_page ? $query->paginate($request->per_page) : $query->get());
    }
}
