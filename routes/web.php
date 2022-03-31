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

Auth::routes();

Route::get('/', function () {
    return view('welcome');
})->name('main');

Route::get('/profile', 'HomeController@index')->name('profile');
Route::get('/setwebhook-telegramm-bot', 'TelegramBotController@setWebhook');
Route::any('/telegramm-bot-message', 'TelegramBotController@getMessage');
Route::get('/summernote-example', 'ExampleController@summernote')->name('summernote');

Route::get('/create-news', 'NewsController@createView')->name('create.news.view');
Route::post('/create-news', 'NewsController@store')->name('create.news');
Route::get('/news', 'NewsController@index')->name('news');
Route::get('/all-news', 'NewsController@show')->name('show.news');
Route::get('/remove-news/{id}', 'NewsController@destroy')->name('destroy.news');
Route::get('/edit-news/{id}', 'NewsController@editView')->name('edit.news.view');
Route::post('/edit-news/', 'NewsController@edit')->name('edit.news');
Route::get('/test', 'AutoGenerate\GeneratedViewController@test');
//placeForAutoGenerateRoute
