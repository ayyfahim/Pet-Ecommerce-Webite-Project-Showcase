<?php

Route::group([
        'prefix' => 'productattribute',
        'as' => 'productattribute.',
    ], function () {
        Route::get('/', [
            'as'   => 'index',
            'uses' => 'ProductAttributeController@index',
        ]);

        Route::get('create', [
            'as'   => 'create',
            'uses' => 'ProductAttributeController@create',
        ]);

        Route::post('/', [
            'as'   => 'store',
            'uses' => 'ProductAttributeController@store',
        ]);

        Route::get('show/{productattribute}', [
            'as'   => 'show',
            'uses' => 'ProductAttributeController@show',
        ]);

        Route::get('{productattribute}', [
            'as'   => 'edit',
            'uses' => 'ProductAttributeController@edit',
        ]);

        Route::patch('update/{productattribute}', [
            'as'   => 'update',
            'uses' => 'ProductAttributeController@update',
        ]);

        Route::delete('destroy/{productattribute}', [
            'as'   => 'destroy',
            'uses' => 'ProductAttributeController@destroy',
        ]);
    });
