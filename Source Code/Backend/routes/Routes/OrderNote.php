<?php

Route::group([
    'prefix' => 'admin/order_notes',
    'as' => 'order_note.admin.',
    'namespace' => 'Admin',
    'middleware' => 'manager_access',
], function () {
    /* -------------------------------- resource -------------------------------- */
    Route::post('/', [
        'as' => 'store',
        'uses' => 'ManagerOrderNoteController@store',
    ]);

});
