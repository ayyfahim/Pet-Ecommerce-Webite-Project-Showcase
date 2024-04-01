<?php

Route::group([
    'namespace' => 'Api',
], function () {
    Route::get('lang-vars', 'HelperController@getLangVars');
    Route::get('global-data', 'HelperController@getGlobalData');
    Route::get('paginate-date', 'HelperController@paginateData');
});
