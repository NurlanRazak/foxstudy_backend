<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    Route::crud('category', 'CategoryCrudController');
    Route::crud('subcategory', 'SubcategoryCrudController');
    Route::crud('course', 'CourseCrudController');
    Route::crud('student', 'StudentCrudController');
    Route::crud('company', 'CompanyCrudController');
    Route::crud('vacancy', 'VacancyCrudController');
    Route::crud('staff', 'StaffCrudController');
    Route::crud('question', 'QuestionCrudController');
    Route::crud('option', 'OptionCrudController');
    Route::crud('answer', 'AnswerCrudController');
    Route::crud('user', 'UserCrudController');
    Route::crud('score', 'ScoreCrudController');
    Route::crud('feedback', 'FeedbackCrudController');
    Route::crud('manager', 'ManagerCrudController');
    Route::crud('subscription', 'SubscriptionCrudController');
    Route::crud('article', 'ArticleCrudController');
    Route::crud('lesson', 'LessonCrudController');
}); // this should be the absolute last line of this file