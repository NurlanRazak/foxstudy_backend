<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{

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
        ]);

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
}
