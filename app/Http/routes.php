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
    Route::resource('users', 'UserController', ['only' => ['index', 'store', 'show', 'update', 'destroy' ]]);
    Route::get('users/{id}/groups', 'UserController@groups');

    // groups
    Route::resource('groups', 'GroupController', ['only' => ['index', 'store', 'show', 'update', 'destroy' ]]);
    Route::get('groups/{id}/users', 'GroupController@users');
    Route::get('groups/{id}/tags', 'GroupController@tags');

    // current authenticated user
    Route::group([
        'prefix' => '/me',
    ], function(){
        Route::get('/', 'UserController@me');
        Route::get('groups', 'UserController@meGroups');
        Route::get('modulesTaken', 'UserController@meModulesTaken');
        Route::get('resync', 'UserController@meResync');
    });
});