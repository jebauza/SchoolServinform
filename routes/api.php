<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/* Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
}); */

Route::middleware(['ajax'])->name('api.')->group(function () {

    /* Students */
    Route::prefix('students')->name('students.')->group(function () {
        Route::get('/', 'Api\StudentApiController@index')->name('index');
        Route::get('/paginate', 'Api\StudentApiController@paginate')->name('paginate');
        Route::post('/store', 'Api\StudentApiController@store')->name('store');
        Route::get('/{id}/show', 'Api\StudentApiController@show')->name('show');
        Route::put('/{id}/update', 'Api\StudentApiController@update')->name('update');
        Route::delete('/{id}/destroy', 'Api\StudentApiController@destroy')->name('destroy');
    });

    /* Courses */
    Route::prefix('courses')->name('courses.')->group(function () {
        Route::get('/', 'Api\CourseApiController@index')->name('index');
        Route::get('/paginate', 'Api\CourseApiController@paginate')->name('paginate');
        Route::post('/store', 'Api\CourseApiController@store')->name('store');
        Route::get('/{id}/show', 'Api\CourseApiController@show')->name('show');
        Route::put('/{id}/update', 'Api\CourseApiController@update')->name('update');
        Route::delete('/{id}/destroy', 'Api\CourseApiController@destroy')->name('destroy');
    });

    /* Events */
    Route::prefix('events')->name('events.')->group(function () {
        Route::get('/', 'Api\EventApiController@index')->name('index');
    });

    /* Seeders */
    Route::get('/seeders', function () {
        Artisan::call('migrate:refresh');
        Artisan::call('db:seed', ['--class' => 'StudentCourseSeeder']);
        return response()->json([
            'ok' => true,
            'message' => 'Test data has been inserted'
        ], 200);
    })->name('seeders');
});
