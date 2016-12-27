<?php

Auth::routes();
Route::post('password/change', 'UserController@changePassword')->middleware('auth');
Route::get('auth/github', 'Auth\AuthController@redirectToProvider');
Route::get('auth/github/callback', 'Auth\AuthController@handleProviderCallback');
Route::get('auth/github/register', 'Auth\AuthController@create');
Route::post('auth/github/register', 'Auth\AuthController@store');

Route::get('search', 'HomeController@search');

Route::get('discussion', 'DiscussionController@index');
Route::get('discussion/create', 'DiscussionController@create')->middleware('auth');
Route::get('discussion/{id}', 'DiscussionController@show');
Route::post('discussion', 'DiscussionController@store')->middleware('auth');
Route::get('discussion/{id}/edit', 'DiscussionController@edit')->middleware('auth');
Route::put('discussion/{id}', 'DiscussionController@update')->middleware('auth');

Route::get('user', 'UserController@index');
Route::post('user/avatar', 'UserController@avatar')->middleware('auth');
Route::post('crop/api', 'UserController@cropAvatar')->middleware('auth');
Route::get('user/profile', 'UserController@edit')->middleware('auth');
Route::put('user/profile/{id}', 'UserController@update')->middleware('auth');
Route::post('user/follow/{id}', 'UserController@doFollow')->middleware('auth');
Route::get('user/{username}/following', 'UserController@following');
Route::get('user/{username}/discussions', 'UserController@discussions');
Route::get('user/{username}/comments', 'UserController@comments');
Route::get('user/{username}', 'UserController@show');

Route::group(['middleware' => 'auth'], function () {
    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::get('setting/notification', 'SettingController@notification')->name('setting.notification');
    Route::post('setting/notification', 'SettingController@setNotification');
    Route::get('setting/binding', 'SettingController@binding')->name('setting.binding');
});

Route::get('link', 'LinkController@index');
Route::get('category/{category}', 'CategoryController@show');
Route::get('category', 'CategoryController@index');

Route::get('tag', 'TagController@index');
Route::get('tag/{tag}', 'TagController@show');

/* Dashboard Index */
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth', 'admin']], function () {
   Route::get('{path?}', 'HomeController@dashboard')->where('path', '[\/\w\.-]*');
});

Route::get('/', 'ArticleController@index');
Route::get('{slug}', 'ArticleController@show');