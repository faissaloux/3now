<?php

Route::get('/', 'CmsController@index')->name('index');

/*
|--------------------------------------------------------------------------
| CMS Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'CmsController@dashboard')->name('index');
Route::get('/dashboard', 'CmsController@dashboard')->name('dashboard');

Route::resource('blog', 'Resource\BlogResource');
Route::resource('page', 'Resource\PageResource');

Route::get('profile', 'CmsController@profile')->name('profile');
Route::post('profile', 'CmsController@profile_update')->name('profile.update');

Route::get('password', 'CmsController@password')->name('password');
Route::post('password', 'CmsController@password_update')->name('password.update');
