<?php

Route::group([
    'prefix' => 'admin/social_feeds',
    'as' => 'social_feed.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerSocialFeedController@index',
    ]);

    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerSocialFeedController@create',
    ]);
    Route::get('export/{type}', [
        'as' => 'export',
        'uses' => 'ManagerSocialFeedController@export',
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerSocialFeedController@store',
    ]);

    Route::get('edit/{social_feed}', [
        'as' => 'edit',
        'uses' => 'ManagerSocialFeedController@edit',
    ]);

    Route::patch('update/{social_feed}', [
        'as' => 'update',
        'uses' => 'ManagerSocialFeedController@update',
    ]);

    Route::delete('destroy/{social_feed}', [
        'as' => 'destroy',
        'uses' => 'ManagerSocialFeedController@destroy',
    ]);
});

Route::group(
    [
        'prefix' => 'social',
        'as' => 'social.',
    ],
    function () {
        Route::get('/instagram', [
            'as' => 'instagram',
            'uses' => 'SocialMediaController@getInstagramFeed',
        ]);
    }
);
