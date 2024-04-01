<?php
Route::group([
    'prefix' => 'products',
    'as' => 'product.',
], function () {
    /* -------------------------------- resource -------------------------------- */

    Route::get('/', [
        'as' => 'index',
        'uses' => 'ProductController@index',
    ]);

//    Route::get('{slug}', [
//        'as' => 'show',
//        'uses' => 'ProductController@show',
//    ]);

    Route::get('variations/price/{product}', [
        'as' => 'variation.price',
        'uses' => 'ProductController@getVariationPrice',
    ]);
});


Route::group([
    'prefix' => 'admin/products',
    'as' => 'product.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::get('/', [
        'as' => 'index',
        'uses' => 'ManagerProductController@index',
        'middleware' => 'permission:view_products'
    ]);

    Route::get('import', [
        'as' => 'import',
        'uses' => 'ManagerProductController@import',
        'middleware' => 'permission:add_products'
    ]);

    Route::post('importStore', [
        'as' => 'importStore',
        'uses' => 'ManagerProductController@importStore',
        'middleware' => 'permission:add_products'
    ]);
//    Route::get('import', [
//        'as' => 'import',
//        'uses' => 'ManagerProductController@import',
//        'middleware' => 'permission:add_products'
//    ]);
    Route::get('export', [
        'as' => 'export',
        'uses' => 'ManagerProductController@export',
        'middleware' => 'permission:view_products'
    ]);
    Route::get('create', [
        'as' => 'create',
        'uses' => 'ManagerProductController@create',
        'middleware' => 'permission:add_products'
    ]);

    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerProductController@store',
        'middleware' => 'permission:add_products'
    ]);

    Route::get('{product}', [
        'as' => 'edit',
        'uses' => 'ManagerProductController@edit',
        'middleware' => 'permission:edit_products'
    ]);

    Route::patch('update/{product}', [
        'as' => 'update',
        'uses' => 'ManagerProductController@update',
        'middleware' => 'permission:edit_products'
    ]);

    Route::delete('destroy/{product}', [
        'as' => 'destroy',
        'uses' => 'ManagerProductController@destroy',
        'middleware' => 'permission:delete_products'
    ]);

    Route::get('test', [
        'as' => 'test',
        'uses' => 'ManagerProductController@test',
    ]);

    Route::post('variations/add/{product}', [
        'as' => 'variation.add',
        'uses' => 'ManagerProductController@addVariation',
    ]);
    Route::get('attributes/get', [
        'as' => 'attribute.get',
        'uses' => 'ManagerProductController@getAttribute',
    ]);
    Route::post('faq/add', [
        'as' => 'faq.add',
        'uses' => 'ManagerProductController@addFaq',
    ]);
    Route::post('additional/add', [
        'as' => 'additional.add',
        'uses' => 'ManagerProductController@addAdditional',
    ]);
    Route::post('specification/add', [
        'as' => 'specification.add',
        'uses' => 'ManagerProductController@addSpecification',
    ]);
    Route::post('dosage/add', [
        'as' => 'dosage.add',
        'uses' => 'ManagerProductController@addDosage',
    ]);
    Route::post('nutrition/add_serving', [
        'as' => 'nutrition.add_serving',
        'uses' => 'ManagerProductController@addNutritionServing',
    ]);
    Route::post('nutrition/add_weight', [
        'as' => 'nutrition.add_weight',
        'uses' => 'ManagerProductController@addNutritionWeight',
    ]);
    Route::post('media/add', [
        'as' => 'media.add',
        'uses' => 'ManagerProductController@addMedia',
    ]);
    Route::get('voucher/getCountries', [
        'as' => 'voucher.countries',
        'uses' => 'ManagerProductController@getCountries',
    ]);
    Route::get('voucher/getCities', [
        'as' => 'voucher.cities',
        'uses' => 'ManagerProductController@getCities',
    ]);
});
