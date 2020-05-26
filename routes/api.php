<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::get('vacancy', 'VacancyController@vacancy');
Route::post('application', 'VacancyController@application');

Route::get('test', 'QuestionController@test')->name('test');
Route::post('score', 'QuestionController@scoreTest');

Route::post('login', 'AuthController@login')->name('login');
Route::post('register', 'AuthController@register')->name('register');

Route::post('feedback', 'FeedbackController@feedback');
Route::post('subscription', 'SubscriptionController@subscription');
// Route::post('password', 'AuthController@resetPassword');
// Route::put('password', 'AuthController@updatePassword')->middleware('auth:api');
Route::get('categories', 'CategoryController@index');
Route::get('subcategories', 'CategoryController@subcategories');

Route::get('courses', 'CategoryController@courses');
Route::get('courses/{course_id}', 'CategoryController@course');

Route::get('lessons', 'CategoryController@lessons');
Route::get('lessons/{lesson_id}', 'CategoryController@lesson');

Route::get('search', 'CategoryController@search');

Route::get('articles', 'ContentController@articles');
Route::get('articles/{article_id}', 'ContentController@article');

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
