<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Option;
use App\Models\Staff;
use App\Models\Vacancy;
use App\Models\Score;
use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{


    public function test(Request $request)
    {
        $data = [];

        $questions = Question::active()->whereHas('vacancies', function($query) use($request) {
            $query->where('vacancy_id', $request->id);
        })->get();

        if(!$questions)
        {
            return response()->json([
                'message' => 'Not Found',
            ], 404);
        }

        foreach($questions as $question) {
            $data[] = new QuestionResource($question);
        }

        return response()->json([
            'data' => $data,
            'message' => 'OK',
        ]);
    }

    public function scoreTest(Request $request)
    {
        $staff = Staff::where('email', $request->email)->first();
        $vacancy_id = Vacancy::where('id', $staff->vacancy_id)->first()->id;

        $score = new Score();
        $score->staff_id = $staff->id;
        $score->vacancy_id = $vacancy_id;

        $right_answer_num = 0;
        $tests = $request->test;

        $right_answer = '';
        foreach($tests as $test) {
            $question = Question::where('id', $test['question_id'])->first();
            foreach($question->answers as $ans) {
                $right_answer = Option::where('id', $ans->option_id)->first();
            }

            $answer = Option::where('id', $test['option_id'])->first();

            if($right_answer->id == $answer->id) {
                $right_answer_num++;
            }
        }

        $score->score = $right_answer_num  * 100 / count($tests);
        $score->save();

        return response()->json([
            'success' => true,
            'message' => 'All results saved!',
            'result' => $score->score,
        ]);

    }
}
