<?php

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/folders/create', 'FolderController@showCreateForm')->name('folders.create');
    Route::post('/folders/create', 'FolderController@create');

    // Route::group(['middleware' => 'can:view,id'], function () {
    Route::get('/folders/{id}/tasks', 'TaskController@index')->name('tasks.index');
    // Route::get('/folders/{folder}/tasks', 'TaskController@index')->name('tasks.index');

    Route::get('/folders/{id}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
    Route::post('/folders/{id}/tasks/create', 'TaskController@create');
    // Route::get('/folders/{folder}/tasks/create', 'TaskController@showCreateForm')->name('tasks.create');
    // Route::post('/folders/{folder}/tasks/create', 'TaskController@create');

    Route::get('/folders/{id}/tasks/{task_id}/edit', 'TaskController@showEditForm')->name('tasks.edit');
    Route::post('/folders/{id}/tasks/{task_id}/edit', 'TaskController@edit');    
    // Route::get('/folders/{folder}/tasks/{task}/edit', 'TaskController@showEditForm')->name('tasks.edit');
    // Route::post('/folders/{folder}/tasks/{task}/edit', 'TaskController@edit');
    // });
});

Auth::routes();
