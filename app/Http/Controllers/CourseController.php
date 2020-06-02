<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subscription;

class CourseController extends Controller
{

    public function subscription(Request $request)
    {
                dd('here');
        $user = $request->user();

        $course_id = $request->course;
        $data = [];
        $data['name'] = $user->name ?? null;
        $data['phone_number'] = $user->phone ?? null;
        $data['email'] = $user->email ?? null;
        $data['user_id'] = $user->id;
        $data['course_id'] = $course_id;

        $subscription = Subscription::create($data);

        return response()->json([
            'success' => true,
            'message' => trans('admin.subscription_success')
        ]);
    }
}
