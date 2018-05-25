<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('auth/user', function (Request $request) {
    return $request->user();
});

Route::group(array('prefix' => 'v1', 'middleware' => ['api', 'cors']), function () {

    Route::resource('projects', 'ProjectControllerJson')->only([
        'index', 'show'
    ]);

    Route::resource('ideas', 'IdeaControllerJson')->only([
        'index', 'show'
    ]);
    
    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/login', 'AuthController@login');

    Route::group(['middleware' => ['jwt.auth']], function () {
        Route::get('auth/user', 'AuthController@user');
        Route::post('auth/logout', 'AuthController@logout');
        Route::resource('ideas', 'IdeaControllerJson')->only([
            'store', 'update', 'destroy'
        ]);
        Route::resource('projects', 'ProjectControllerJson')->only([
            'store', 'update', 'destroy'
        ]);
        Route::post('vote', 'VoteControllerJson@store');
    });
    Route::group(['middleware' => ['jwt.refresh']], function () {
        Route::get('auth/refresh', 'AuthController@refresh');
    });
});

/*
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
    }); */
