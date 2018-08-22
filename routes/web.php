<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'web', 'namespace' => 'Admin'], function () {
    Route::post('login', 'LoginController@login')->name('login_check');
    Route::get('/', 'LoginController@showLoginForm')->name('login');
    Route::get('logout', 'LoginController@logout')->name('logout');
});

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'namespace' => 'Admin', 'as' => 'admin_'], function () {
    Route::get('/', 'DashboardController@index')->name('dashboard');

    Route::get('/queries', 'QueryController@index')->name('query_index');
    Route::get('/query/view/{id}', 'QueryController@view')->name('query_view');
    Route::get('/query/image/{hash}', 'QueryController@image')->name('query_image');

});

