<?php

Route::group([
    'prefix' => 'frontend',
    'as' => 'frontend.',
],
    function () {
        Route::get('/homepage', [
            'as' => 'homepage',
            'uses' => 'FrontendController@homepage',
        ]);
        Route::get('/reward-program', [
            'as' => 'reward_program',
            'uses' => 'FrontendController@reward_program',
        ]);
        Route::get('/about-us', [
            'as' => 'about_us',
            'uses' => 'FrontendController@about_us',
        ]);
    }
);

Route::group([
    'prefix' => 'admin/frontend',
    'as' => 'frontend.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::group([
        'prefix' => 'pages',
        'as' => 'page.',
    ], function () {
        /* -------------------------------- resource -------------------------------- */
        Route::get('/homepage', [
            'as' => 'homepage',
            'uses' => 'ManagerFrontendController@homepage',
            'middleware' => 'permission:view_pages'
        ]);
        Route::post('/homepage', [
            'as' => 'homepage.store',
            'uses' => 'ManagerFrontendController@homepageStore',
            'middleware' => 'permission:view_pages'
        ]);
        Route::get('/reward-program', [
            'as' => 'reward_program',
            'uses' => 'ManagerFrontendController@reward_program',
            'middleware' => 'permission:view_pages'
        ]);
        Route::post('/reward_program', [
            'as' => 'reward_program.store',
            'uses' => 'ManagerFrontendController@rewardProgramStore',
            'middleware' => 'permission:view_pages'
        ]);
        Route::get('/about-us', [
            'as' => 'about_us',
            'uses' => 'ManagerFrontendController@about_us',
            'middleware' => 'permission:view_pages'
        ]);
        Route::post('/about-us', [
            'as' => 'about_us.store',
            'uses' => 'ManagerFrontendController@aboutUsStore',
            'middleware' => 'permission:view_pages'
        ]);
    });
});
