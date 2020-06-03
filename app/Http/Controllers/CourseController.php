<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Subscription;
use App\Models\Course;

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
        $data['user_id'] = $user->id;
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

        return $this->checkout($subscription->id, $course);

        return response()->json([
            'success' => true,
            'message' => trans('admin.subscription_success')
        ]);
    }

    private function checkout($subscription_id, $course)
    {
        $description = 'test' ?? $course->name;

        $url = 'https://api.paybox.money/payment.php';

        $data = [
            'pg_merchant_id' => 529398,//our id in Paybox, will be gived on contract
            'pg_amount' => $course->price, //amount of payment
            'pg_salt' => 'some string', //random string, required
            'pg_order_id' => $subscription_id, //id of purchase, strictly unique
            'pg_description' => $description, //will be shown to client in process of payment, required
            'pg_result_url' => route('payment-result'),//route('payment-result')
            'pg_testing_mode' => 1,
            'pg_success_url' => 'https://foxstudy.kz'
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
        if ($request->pg_result) {
            $order = Subscription::where('id', (int)$request->pg_order_id)->firstOrFail();
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
}
