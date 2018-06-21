<?php

Route::get('/', 'ExampleController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
