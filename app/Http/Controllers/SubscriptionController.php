<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subscription;

class SubscriptionController extends Controller
{

    public function subscription(Request $request)
    {
        $subscription = Subscription::create($request->toArray());
        return response()->json([
            'success' => true,
            'message' => trans('admin.subscription_success')
        ]);
    }
}
