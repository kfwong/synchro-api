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
    'middleware' => 'auth.token.ivle',
], function(){

    // users
    Route::resource('users', 'UserController', ['only' => ['index', 'store', 'show', 'update', 'destroy' ]]);
    Route::get('users/{id}/groups', 'UserController@groups');
    Route::get('me', 'UserController@me');

    // groups
    Route::resource('groups', 'GroupController', ['only' => ['index', 'store', 'show', 'update', 'destroy' ]]);
    Route::get('groups/{id}/users', 'GroupController@users');
});