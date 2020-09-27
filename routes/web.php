<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', 'ArticlesController@index')->name('home');

Auth::routes();

/**
 * Allows to manage own articles for the 
 * registered and logged in users only.
 */
Route::get('artmanager', 'ArtManagerController@index')->name('artmanager');

/**
 * Partially resourceful controller, used to display articles list, 
 * and page for the specified article.
 */
Route::resource('articles', 'ArticlesController')->except([
    'create'
]);

/**
 * Search Articles by Title & Description
 */
Route::post('search', 'ArticlesController@search')->name('articles.search');