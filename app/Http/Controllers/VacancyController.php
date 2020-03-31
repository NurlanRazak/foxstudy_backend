<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\JobResource;
use App\Models\Vacancy;
use App\Models\Staff;

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

    public function application(Request $request)
    {
        $application = Staff::create($request->toArray());
        return response()->json([
            'status' => '200',
            'successfull' =>true
        ]);
        //name, phone_number, email
    }
}
