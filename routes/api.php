<?php

use Illuminate\Http\Request;

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
Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(array('prefix' => 'v1', 'middleware' => ['cors']), function () {
    Route::group(['middleware' => ['auth:api']], function() {
        Route::resource('ideas', 'IdeaControllerJson');
        Route::resource('projects', 'ProjectControllerJson');
        Route::post('vote', 'VoteControllerJson@store');
    });

    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/login', 'AuthController@login');

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('auth/user', 'AuthController@user');
        Route::post('auth/logout', 'AuthController@logout');
    });
    Route::group(['middleware' => ['jwt.refresh']], function () {
        Route::get('auth/refresh', 'AuthController@refresh');
    });
});
