<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subscription;
use App\Models\Homework;
use App\Http\Resources\HomeworkResource;
use App\Models\Course;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{

    public function subscription(Request $request)
    {
        $user = $request->user();

        $course_id = $request->course;
        $data = [];
        $data['name'] = $user->name ?? null;
        $data['phone_number'] = $user->phone ?? null;
        $data['email'] = $user->email ?? null;
        // $data['user_id'] = $user->id;
        $data['course_id'] = $course_id;
        $exists = Subscription::where('course_id', $course_id)->where('user_id', $user->id)->first();

        if ($exists) {
            return response()->json([
                'status' => false,
                'message' => trans('admin.course_exists'),
            ])->setStatusCode(400);
        }
        $subscription = Subscription::create($data);
        $course = Course::find($course_id);

        return $this->checkout($subscription->id, $course, $user->id);

        return response()->json([
            'success' => true,
            'message' => trans('admin.subscription_success')
        ]);
    }

    private function checkout($subscription_id, $course, $user_id)
    {
        $description = $course->name ?? 'test';

        $url = 'https://api.paybox.money/payment.php';

        $data = [
            'extra_user_id' => $user_id,
            'pg_merchant_id' => 529398,//our id in Paybox, will be gived on contract
            'pg_amount' => $course->price, //amount of payment
            'pg_salt' => 'some string', //random string, required
            'pg_order_id' => $subscription_id, //id of purchase, strictly unique
            'pg_description' => $description, //will be shown to client in process of payment, required
            'pg_result_url' => route('payment-result'),//route('payment-result')
            'pg_testing_mode' => 1,
            'pg_success_url' => 'https://foxstudy.kz/cabinet?success=true',
        ];

        ksort($data);
        array_unshift($data, 'payment.php');
        array_push($data, 'YEKj9XtfgaYnOkss');

        $data['pg_sig'] = md5(implode(';', $data));

        unset($data[0], $data[1]);

        $query = http_build_query($data);
        $arr = [$url, $query];

        return $arr;
        header('Location:https://api.paybox.money/payment.php?'.$query);

    }

    public function result(Request $request)
    {
//        Log::info($request->toArray());
        if ($request->pg_result) {
            $order = Subscription::where('id', (int)$request->pg_order_id)->firstOrFail();
            $order->user_id = (int)$request->extra_user_id;
            $order->payment_status = Subscription::PAID;
            $order->save();
            return response()->json([
                'message' => 'ok',
                'success' => true
            ])->setStatusCode(200);

        }
        return response()->json([
            'message' => 'fail in life',
            'success' => false
        ])->setStatusCode(400);
    }


    public function uploadHomework(Request $request)
    {
        $user = $request->user();
        $homework = Homework::find($request->homework_id);
        if(!$homework) {
            abort(400, 'homework not found');
        }

        $homework->user_id = $user->id;
        $homework->file = $request->file;

        $homework->save();

        return response()->json([
            'message' => url('uploads/'.$homework->file),
            'success' => true
        ])->setStatusCode(200);
    }

    public function userHomeworks(Request $request)
    {
        $user = $request->user();
        $homeworks = Homework::where('user_id', $user->id)->get();

        $data = [];

        foreach($homeworks as $homework) {
            $data[] = new HomeworkResource($homework);
        }

        return response()->json([
            'data' => $data,
            'message' => 'OK, keep going, u doing well.',
        ]);
    }
}
