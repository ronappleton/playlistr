<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('play/{itemId}', 'ApiController@play');
Route::get('lists/{playlistId}', 'ApiController@getPlaylist');
Route::get('lists', 'ApiController@getLists');
