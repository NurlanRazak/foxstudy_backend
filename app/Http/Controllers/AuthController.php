<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use App\Notifications\PasswordResetRequest;
use App\Notifications\PasswordResetSuccess;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Carbon;
use App\Models\Course;
use App\Http\Resources\CourseResource;

class AuthController extends Controller
{

    public function getUser(Request $request)
    {
        $user = $request->user();
        $course_ids = [];
        $course_collection = [];
        foreach($user->subscriptions as $subscription) {
            $course_ids[] = $subscription->course_id;
        }

        if($course_ids == null) {
            return response()->json($user);
        } else {
            $course_collection = Course::find($course_ids);
        }

        $data['user'] = $user;
        $data['courses'] = $course_collection ?? null;
        return response()->json($data);
    }

    public function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();

        if($user) {
            if(Hash::check($request->password, $user->password)) {
                $client = DB::table('oauth_clients')->find(2);

                request()->request->add([
                    'client_id' => $client->id,
                    'client_secret' => $client->secret,
                    'grant_type' => 'password',
                    'username' => $request->email,
                    'password' => $request->password,
                ]);

                $token = Request::create(
                    '/oauth/token',
                    'POST'
                );
                return Route::dispatch($token);

            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('admin.password_mismatch'),
                ])->setStatusCode(422);
            }
        } else {
            return response()->json([
                'success' => false,
                'message' => trans('admin.user_not_found'),
            ])->setStatusCode(422);
        }

    }


    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed'
        ], $this->customMessages());

        $data = $request->toArray();
        $data['password'] = Hash::make($request->password);
        $user = User::create($data);
        $client = DB::table('oauth_clients')->find(2);
        $params = [
            'grant_type' => 'password',
            'client_id' => $client->id,
            'client_secret' => $client->secret,
            'username' => request('email'),
            'password' => request('password'),
            'scope' => '*'
        ];
        request()->request->add($params);
        $proxy = Request::create(
            '/oauth/token',
            'POST'
        );
        return Route::dispatch($proxy);

    }

    // public function logout(Request $request)
    // {
    //     $value = $request->bearerToken();
    //     $id = (new Parser())->parse($value)->getHeader('jti');
    //     $token = $request->user()->tokens->find($id);
    //     $token->revoke();
    //
    //     return response()->json([
    //         'success' => true,
    //         'message' => trans('admin.logged_out'),
    //     ])->setStatusCode(200);
    // }


    public function createPasswordReset(Request $request)
    {
        $this->validate($request,[
            'email' => 'required|string|email',
        ], $this->customMessages());

        $user = User::where('email', $request->email)->first();

        if(!$user) {
            return response()->json([
                'message' => trans('admin.user_not_found')
            ])->setStatusCode(404);
        }
        $passwordReset = PasswordReset::updateOrCreate(
            ['email' => $user->email],
            [
                'email' => $user->email,
                'token' => str_random(60),
            ]
        );

        if ($user && $passwordReset) {
            $user->notify(new PasswordResetRequest($passwordReset->token, $passwordReset->email));
        }

        return response()->json([
            'message' => trans('admin.token_sent'),
            'success' => true,
        ])->setStatusCode(200);

    }

    public function findToken($token)
    {
        $passwordReset = PasswordReset::where('token', $token)->first();

        if(!$passwordReset) {
            return response()->json([
                'message' => trans('admin.token_invalid'),
                'success' => false,
            ])->setStatusCode(404);
        }

        if(Carbon\Carbon::parse($passwordReset->updated_at)->addMinutes(30)->isPast()) {
            $passwordReset->delete();
            return response()->json([
                'message' => trans('admin.token_invalid'),
            ])->setStatusCode(404);
        }

        return response()->json($passwordReset);
    }


    public function resetPassword(Request $request)
    {
        $this->validate($request, [
            'email'    => 'required|string|email',
            'password' => 'required|string|confirmed',
            'token'    => 'required|string'
        ], $this->customMessages());

        $passwordReset = PasswordReset::where([
            ['token', $request->token],
            ['email', $request->email]
        ])->first();

        if(!$passwordReset) {
            return response()->json([
                'message' => trans('admin.token_invalid'),
                'success' => false,
            ])->setStatusCode(404);
        }

        $user = User::where('email', $passwordReset->email)->firstOrFail();

        if(!$user) {
            return response()->json([
                'success' => false,
                'message' => trans('admin.user_not_found'),
            ])->setStatusCode(422);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        $passwordReset->delete();

        $user->notify(new PasswordResetSuccess($passwordReset));

        return response()->json($user);
    }

    public function updatePassword(Request $request)
    {

    }
    private function customMessages()
    {
        return  [
            'required' => trans('admin.name_required'),
            'unique' => trans('admin.validation_unique'),
            'confirmed' => trans('admin.password_confirmed'),
            'min'   => trans('admin.min_string'),
        ];
    }


}
