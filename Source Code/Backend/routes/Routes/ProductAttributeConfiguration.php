<?php

Route::group([
        'prefix' => 'productattributeconfiguration',
        'as' => 'productattributeconfiguration.',
    ], function () {
        Route::get('/', [
            'as'   => 'index',
            'uses' => 'ProductAttributeConfigurationController@index',
        ]);

        Route::get('create', [
            'as'   => 'create',
            'uses' => 'ProductAttributeConfigurationController@create',
        ]);

        Route::post('/', [
            'as'   => 'store',
            'uses' => 'ProductAttributeConfigurationController@store',
        ]);

        Route::get('show/{productattributeconfiguration}', [
            'as'   => 'show',
            'uses' => 'ProductAttributeConfigurationController@show',
        ]);

        Route::get('{productattributeconfiguration}', [
            'as'   => 'edit',
            'uses' => 'ProductAttributeConfigurationController@edit',
        ]);

        Route::patch('update/{productattributeconfiguration}', [
            'as'   => 'update',
            'uses' => 'ProductAttributeConfigurationController@update',
        ]);

        Route::delete('destroy/{productattributeconfiguration}', [
            'as'   => 'destroy',
            'uses' => 'ProductAttributeConfigurationController@destroy',
        ]);
    });
