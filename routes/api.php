<?php

Route::group([
    'middleware' => ['auth:api', 'admin'],
    'namespace' => 'Api',
], function () {
    Route::get('statistics', 'HomeController@statistics');

    // User
    Route::get('user', 'UserController@index')->middleware(['permission:list_user']);
    Route::post('user', 'UserController@store')->middleware(['permission:create_user']);
    Route::get('user/{id}/edit', 'UserController@edit')->middleware(['permission:update_user']);
    Route::patch('user/{id}', 'UserController@update')->middleware(['permission:update_user']);
    Route::delete('user/{id}', 'UserController@destroy')->middleware(['permission:destroy_user']);
    Route::post('/user/{id}/status', 'UserController@status')->middleware(['permission:update_user']);

    // Article
    Route::get('article', 'ArticleController@index')->name('api.article.index')->middleware(['permission:list_article']);
    Route::post('article', 'ArticleController@store')->name('api.article.store')->middleware(['permission:create_article']);
    Route::get('article/{id}/edit', 'ArticleController@edit')->name('api.article.edit')->middleware(['permission:update_article']);
    Route::patch('article/{id}', 'ArticleController@update')->name('api.article.update')->middleware(['permission:update_article']);
    Route::delete('article/{id}', 'ArticleController@destroy')->name('api.article.destroy')->middleware(['permission:destroy_article']);

    // Category
    Route::get('category', 'CategoryController@index')->middleware(['permission:list_category']);
    Route::post('category', 'CategoryController@store')->middleware(['permission:create_category']);
    Route::get('category/{id}/edit', 'CategoryController@edit')->middleware(['permission:update_category']);
    Route::patch('category/{id}', 'CategoryController@update')->middleware(['permission:update_category']);
    Route::delete('category/{id}', 'CategoryController@destroy')->middleware(['permission:destroy_category']);
    Route::get('/categories', 'CategoryController@getList')->middleware(['permission:create_article|update_article']);

    // Discussion
    Route::get('discussion', 'DiscussionController@index')->middleware(['permission:list_discussion']);
    Route::post('discussion', 'DiscussionController@store')->middleware(['permission:create_discussion']);
    Route::get('discussion/{id}/edit', 'DiscussionController@edit')->middleware(['permission:update_discussion']);
    Route::patch('discussion/{id}', 'DiscussionController@update')->middleware(['permission:update_discussion']);
    Route::delete('discussion/{id}', 'DiscussionController@destroy')->middleware(['permission:destroy_discussion']);
    Route::post('/discussion/{id}/status', 'DiscussionController@status')->middleware(['permission:update_discussion']);

    // Tag
    Route::get('comment', 'CommentController@index')->middleware(['permission:list_comment']);
    Route::get('comment/{id}/edit', 'CommentController@edit')->middleware(['permission:update_comment']);
    Route::patch('comment/{id}', 'CommentController@update')->middleware(['permission:update_comment']);
    Route::delete('comment/{id}', 'CommentController@destroy')->middleware(['permission:destroy_comment']);

    // Tag
    Route::get('tag', 'TagController@index')->middleware(['permission:list_tag']);
    Route::post('tag', 'TagController@store')->middleware(['permission:create_tag']);
    Route::get('tag/{id}/edit', 'TagController@edit')->middleware(['permission:update_tag']);
    Route::patch('tag/{id}', 'TagController@update')->middleware(['permission:update_tag']);
    Route::delete('tag/{id}', 'TagController@destroy')->middleware(['permission:destroy_tag']);

    // Link
    Route::get('link', 'LinkController@index')->middleware(['permission:list_link']);
    Route::post('link', 'LinkController@store')->middleware(['permission:create_link']);
    Route::get('link/{id}/edit', 'LinkController@edit')->middleware(['permission:update_link']);
    Route::patch('link/{id}', 'LinkController@update')->middleware(['permission:update_link']);
    Route::delete('link/{id}', 'LinkController@destroy')->middleware(['permission:destroy_link']);
    Route::post('/link/{id}/status', 'LinkController@status')->middleware(['permission:update_link']);

    Route::get('role', 'RoleController@index')->middleware(['permission:list_role']);
    Route::post('role', 'RoleController@store')->middleware(['permission:create_role']);
    Route::get('role/{id}/edit', 'RoleController@edit')->middleware(['permission:update_role']);
    Route::patch('role/{id}', 'RoleController@update')->middleware(['permission:update_role']);
    Route::delete('role/{id}', 'RoleController@destroy')->middleware(['permission:destroy_role']);
    Route::get('permissions', 'PermissionsController@index')->middleware(['permission:update_role_permissions']);
    Route::post('role/{role}/permissions', 'RoleController@updateRolePermissions')->middleware(['permission:update_role_permissions']);

    Route::get('visitor', 'VisitorController@index')->middleware(['permission:list_visitor']);

    Route::get('upload', 'UploadController@index')->middleware(['permission:list_file']);
    Route::post('upload', 'UploadController@uploadForManager')->middleware(['permission:upload_file']);
    Route::post('folder', 'UploadController@createFolder')->middleware(['permission:create_file_folder']);
    Route::post('folder/delete', 'UploadController@deleteFolder')->middleware(['permission:destroy_file']);
    Route::post('file/delete', 'UploadController@deleteFile')->middleware(['permission:destroy_file']);

    Route::get('system', 'SystemController@getSystemInfo')->middleware(['permission:list_system_info']);
});

Route::group([
    'namespace' => 'Api',
], function () {
    // File Upload
    Route::post('file/upload', 'UploadController@fileUpload')->middleware('auth:api');
    // Edit Avatar
    Route::post('crop/avatar', 'UserController@cropAvatar')->middleware('auth:api');

    // Comment
    Route::get('commentable/{commentableId}/comment', 'CommentController@show')->middleware('api');
    Route::post('comments', 'CommentController@store')->middleware('auth:api');
    Route::delete('comments/{id}', 'CommentController@destroy')->middleware('auth:api');
    Route::post('comments/vote/{type}', 'MeController@postVoteComment')->middleware('auth:api');
    Route::get('tags', 'TagController@getList');
});
