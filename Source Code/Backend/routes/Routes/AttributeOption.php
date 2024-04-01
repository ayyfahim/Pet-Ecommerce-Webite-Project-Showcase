<?php

Route::group([
        'prefix' => 'attributeoption',
        'as' => 'attributeoption.',
    ], function () {
        Route::get('/', [
            'as'   => 'index',
            'uses' => 'AttributeOptionController@index',
        ]);

        Route::get('create', [
            'as'   => 'create',
            'uses' => 'AttributeOptionController@create',
        ]);

        Route::post('/', [
            'as'   => 'store',
            'uses' => 'AttributeOptionController@store',
        ]);

        Route::get('show/{attributeoption}', [
            'as'   => 'show',
            'uses' => 'AttributeOptionController@show',
        ]);

        Route::get('{attributeoption}', [
            'as'   => 'edit',
            'uses' => 'AttributeOptionController@edit',
        ]);

        Route::patch('update/{attributeoption}', [
            'as'   => 'update',
            'uses' => 'AttributeOptionController@update',
        ]);

        Route::delete('destroy/{attributeoption}', [
            'as'   => 'destroy',
            'uses' => 'AttributeOptionController@destroy',
        ]);
    });
