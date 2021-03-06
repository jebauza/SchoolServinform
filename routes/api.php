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
    Route::namespace('Domain\Student\http\Controllers')->prefix('students')->name('students.')->group(function () {
        Route::get('/', 'Api\StudentController@index')->name('index');
        Route::get('/paginate', 'Api\StudentController@paginate')->name('paginate');
        Route::post('/store', 'Api\StudentController@store')->name('store');
        Route::get('/{id}/show', 'Api\StudentController@show')->name('show');
        Route::put('/{id}/update', 'Api\StudentController@update')->name('update');
        Route::delete('/{id}/destroy', 'Api\StudentController@destroy')->name('destroy');
    });

    /* Courses */
    Route::namespace('Domain\Course\http\Controllers')->prefix('courses')->name('courses.')->group(function () {
        Route::get('/', 'Api\CourseController@index')->name('index');
        Route::get('/paginate', 'Api\CourseController@paginate')->name('paginate');
        Route::post('/store', 'Api\CourseController@store')->name('store');
        Route::get('/{id}/show', 'Api\CourseController@show')->name('show');
        Route::put('/{id}/update', 'Api\CourseController@update')->name('update');
        Route::delete('/{id}/destroy', 'Api\CourseController@destroy')->name('destroy');
    });

    /* Events */
    Route::namespace('Domain\Event\http\Controllers')->prefix('events')->name('events.')->group(function () {
        Route::get('/', 'Api\EventController@index')->name('index');
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
