<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('vacancy', 'VacancyController@vacancy');
Route::post('application', 'VacancyController@application');

Route::get('test', 'QuestionController@test')->name('test');

Route::post('login', 'AuthController@login')->name('login');
Route::post('register', 'AuthController@register')->name('register');

// Route::post('password', 'AuthController@resetPassword');
// Route::put('password', 'AuthController@updatePassword')->middleware('auth:api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    // 'namespace'     => 'Auth',
    'middleware'    => 'api',
    'prefix'        => 'password'
], function() {
    Route::post('create', 'AuthController@createPasswordReset');
    Route::get('find/{token}', 'AuthController@findToken');
    Route::post('reset', 'AuthController@resetPassword');
});
