<?php

Auth::routes();

Route::get('/', 'PageController@index');

Route::resource('projects', 'ProjectController');

Route::resource('ideas', 'IdeaController');

Route::get('ideas/create/{id}', 'IdeaController@create');

Route::resource('votes', 'VoteController');