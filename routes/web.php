<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->middleware('verified');
    Route::resource('playlists', 'PlaylistController');
    Route::get('playlistItems/{playlistId}', 'PlaylistItemController@items')
      ->name('playlist.items');
    Route::post('storeBulkUrl', 'PlaylistItemController@storeBulkUrl')->name('playlist.items.store.bulk.url');
    Route::post('storeBulkFile', 'PlaylistItemController@storeBulkFile')->name('playlist.items.store.bulk.file');
    Route::resource('playlistItems', 'PlaylistItemController');
});

Route::get('m3u', function () {
    $media = new \App\Helpers\m3u();
    return response()->json($media->getMedia());
});

