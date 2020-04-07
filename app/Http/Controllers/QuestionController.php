<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;
use App\Models\Option;
use App\Http\Resources\QuestionResource;

class QuestionController extends Controller
{


    public function test(Request $request)
    {
        $data = [];
        $questions = Question::active()->get();
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

        $question = Question::active()->where('id', 1)->firstOrFail();
        $options = $question->options;

        dd($question, $options);

    }
}
