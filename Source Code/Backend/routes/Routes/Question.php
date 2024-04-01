<?php

Route::group([
    'prefix' => 'admin/content/faq',
    'as' => 'question.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerQuestionController@index',
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerQuestionController@create',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerQuestionController@store',
    ]);

    Route::get('edit/{question}', [
        'as' => 'edit',
        'uses' => 'ManagerQuestionController@edit',
    ]);

    Route::patch('update/{question}', [
        'as' => 'update',
        'uses' => 'ManagerQuestionController@update',
    ]);

    Route::delete('destroy/{question}', [
        'as' => 'destroy',
        'uses' => 'ManagerQuestionController@destroy',
    ]);
});
Route::group([
    'prefix' => 'faq',
    'as' => 'question.',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'show',
        'uses' => 'QuestionController@show',
    ]);
});
