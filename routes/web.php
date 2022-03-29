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

Route::get('/create-news', 'NewsController@createView')->name('create.news.blade');
Route::post('/create-news', 'NewsController@store')->name('create.news');
Route::get('/news', 'NewsController@index')->name('news');

//placeForAutoGenerateRoute
