<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('auth/user', function (Request $request) {
    return $request->user();
});
Route::group(['middleware' => ['jwt.auth']], function () {
    Route::delete('/projects/{id}', 'ProjectControllerJson@destroy');
});

Route::group(array('prefix' => 'v1', 'middleware' => ['api', 'cors']), function () {

    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/login', 'AuthController@login');

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('auth/user', 'AuthController@user');
        Route::post('auth/logout', 'AuthController@logout');
        Route::resource('ideas', 'IdeaControllerJson');
        Route::resource('projects', 'ProjectControllerJson');
        Route::post('vote', 'VoteControllerJson@store');
    });
    Route::group(['middleware' => ['jwt.refresh']], function () {
        Route::get('auth/refresh', 'AuthController@refresh');
    });
});
