<?php

Route::group([
        'prefix' => 'address',
        'as' => 'address.',
    ], function () {
        Route::get('/', [
            'as'   => 'index',
            'uses' => 'AddressController@index',
        ]);

        Route::get('create', [
            'as'   => 'create',
            'uses' => 'AddressController@create',
        ]);

        Route::post('/', [
            'as'   => 'store',
            'uses' => 'AddressController@store',
        ]);

        Route::get('show/{address}', [
            'as'   => 'show',
            'uses' => 'AddressController@show',
        ]);

        Route::get('{address}', [
            'as'   => 'edit',
            'uses' => 'AddressController@edit',
        ]);

        Route::patch('update/{address}', [
            'as'   => 'update',
            'uses' => 'AddressController@update',
        ]);
        Route::patch('updateInfo/{addressInfo}', [
            'as'   => 'updateInfo',
            'uses' => 'AddressController@updateInfo',
        ]);

        Route::delete('destroy/{address}', [
            'as'   => 'destroy',
            'uses' => 'AddressController@destroy',
        ]);
    });
