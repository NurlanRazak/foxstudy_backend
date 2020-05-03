<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{

    public function feedback(Request $request)
    {
        $feedback = Feedback::updateOrCreate($request->toArray());
        return response()->json([
            'success' => true,
            'message' => trans('admin.feedback_success')
        ]);
    }
}
