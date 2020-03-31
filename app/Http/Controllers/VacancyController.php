<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Models\Vacancy;

class VacancyController extends Controller
{

    public function vacancy(Request $request)
    {
        $data = [];
        $vacancies = Vacancy::active()->get();
        if(!$vacancies)
        {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }
        foreach($vacancies as $vacancy) {
            $data[] = new JobResource($vacancy);
        }

        return response()->json([
            'data' => $data,
            'message' => 'OK',
        ]);
    }
}
