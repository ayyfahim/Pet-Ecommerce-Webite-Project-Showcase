<?php
Route::get('/', 'HomeController@index')->name('home');
Route::get('/home', 'HomeController@index')->name('api_home');
