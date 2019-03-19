<?php
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/notaccess', function () {
    return view('notaccess');
});

Route::group(['middleware' => 'CheckRolePast:admin'], function() {
    Route::get('/home', 'HomeController@index')->name('home');
});