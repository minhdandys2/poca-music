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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/redirect/{social}', 'SocialAuthController@redirect');
Route::get('/callback/{social}', 'SocialAuthController@callback');
Route::prefix('user')->group(function () {
    Route::get('{id}/edit', 'UserController@edit')->name('user.edit');
    Route::post('{id}/edit', 'UserController@update')->name('user.update');
    Route::get('/change-password', 'UserController@editpass')->name('user.editpass');
    Route::post('/change-password', 'UserController@updatepass')->name('user.updatepass');
    Route::get('{name?}', 'UserController@index')->name('user.index');
});

Route::prefix('song')->group(function () {
    Route::get('create', 'SongController@create')->name('song.create');
    Route::post('store', 'SongController@store')->name('song.store');
    Route::get('edit/{id}', 'SongController@edit')->name('song.edit');
    Route::post('edit/{id}', 'SongController@update')->name('song.update');
    Route::get('delete/{id}', 'SongController@delete')->name('song.delete');
    Route::get('listenMusic/{id}', 'SongController@listen')->name('song.listen');
    Route::get('playlist','SongController@playlist')->name('song.playlist');
});

Route::prefix('playlists')->group(function (){
    Route::get('index', 'PlayListController@index')->name('playlist.index');
    Route::get('create', 'PlayListController@create')->name('playlist.create');
    Route::post('create', 'PlayListController@store')->name('playlist.store');
});
