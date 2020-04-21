<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('vacancy', 'VacancyController@vacancy');
Route::post('application', 'VacancyController@application');

Route::get('test', 'QuestionController@test')->name('test');

Route::post('login', 'AuthController@login')->name('login');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
