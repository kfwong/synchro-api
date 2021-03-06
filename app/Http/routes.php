<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::group([
    'prefix' => '/api/v1',
    'middleware' => 'api',
], function(){

    // users
    Route::resource('users', 'UserController', ['only' => ['index', 'show']]);
    Route::get('users/{id}/groups', 'UserController@groups');
    Route::get('users/{id}/groups/recommends', 'UserController@groupRecommends');
    Route::get('users/{id}/modulesTaken', 'UserController@modulesTaken');
    Route::get('users/{id}/posts', 'UserController@posts');

    // groups
    Route::get('groups/search', 'GroupController@search');
    Route::resource('groups', 'GroupController', ['only' => ['index', 'store', 'show', 'update', 'destroy' ]]);
    Route::get('groups/{id}/users', 'GroupController@users');
    Route::get('groups/{id}/tags', 'GroupController@tags');
    Route::get('groups/{id}/posts', 'GroupController@posts');

    // posts
    Route::resource('posts', 'PostController', ['only' => ['show', 'store']]);

    // current authenticated user
    Route::group([
        'prefix' => '/me',
    ], function(){
        Route::get('/', 'UserController@me');
        Route::put('/', 'UserController@meUpdate');
        Route::get('groups', 'UserController@meGroups');
        Route::post('groups/{id}/join', 'UserController@meJoinGroup');
        Route::post('groups/{id}/leave', 'UserController@meLeaveGroup');
        Route::get('posts', 'UserController@mePosts');
        Route::get('modulesTaken', 'UserController@meModulesTaken');
        Route::get('resync', 'UserController@meResync');
    });

});