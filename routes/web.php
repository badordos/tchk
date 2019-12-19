<?php

Route::get('/', 'TaskController@index')->name('tasks.index');
Route::get('/search', 'TaskController@search')->name('tasks.search');

Route::group(['prefix' => '/api/v1/task',], function () {
    Route::match(['GET', 'POST'], '/', 'TaskController@getTasks')->name('tasks.getTasks');
    Route::match(['GET', 'POST'], '/{id}', 'TaskController@getTask')->name('tasks.getTask');
});
